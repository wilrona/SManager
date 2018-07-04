<?php

namespace App\Http\Controllers;

use App\Repositories\PrecommandeRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SerieRepository;
use App\Repositories\ProvisionsRepository;
use App\Repositories\TransactionsRepository;
use Illuminate\Http\Request;
use App\Typeproduits;
use App\Library\CustomFunction;
use App\PointDeVente;
use App\Precommande;
use Illuminate\Support\Facades\Auth;
use View;

class PrecommandesController extends Controller
{
    //
      //public 

	protected $modelRepository;
	protected $transfertRepository;
	protected $modelPOS;
	protected $transactionsRepository;

	protected $nbrPerPage = 4;
	/**
	 * @var ProduitRepository
	 */
	private $produitRepository;

	public function __construct(PrecommandeRepository $modelRepository, ProvisionsRepository $transfertRepository,
		PointDeVente $modelPOS, TransactionsRepository $transactionsRepository, ProduitRepository $produitRepository)
	{
		$this->modelRepository = $modelRepository;
		$this->transfertRepository = $transfertRepository;

		$this->modelPOS = $modelPOS;
		$this->transactionsRepository = $transactionsRepository;
		$this->produitRepository = $produitRepository;
	}
     
    
    public function index(){
     $precommande = Precommande::paginate(20); 
        return View::make('precommandes.index')
            ->with('datas', $precommande);
    }
    
    
      public function show($id){
        
        $item = Precommande::findOrFail($id);

     //    var_dump($item->produits());
        $res=['item' => $item];
       
       // var_dump($item);
       return View::make('precommandes.show')
            ->with($res);
    } 
    
    
     public function changestate($id, $etat,Request $request){
        
        $data["statut"]=$etat;
                Precommande::where('id', $id)
               ->update($data);
                
        $type="success";
        $message="Précommande annulée";
        if($etat==0){
            $message="Précommande refusée";
        }
        $request->session()->flash('message', $message);
        $request->session()->flash('type', $type);
        return redirect('precommandes');
    }
    
    
    
	public function form($id=null,Request $request){
         //$request->session()->flush();
        $currentUser= Auth::user();
        $prdts = Typeproduits::all('id', 'libelle');
        $pos=PointDeVente::findOrFail($currentUser->id_point_de_vente_encours);
        //$mypos=$pos->enfants();
        //var_dump($pos->enfants());
          
        
        $produit=array();
        $res=['prdts' => $prdts,'produit' => $produit ,'prdtsall' => $prdts, 'pos' =>  $pos];
       // $users = DB::table('typeproduits')->select('id', 'libelle')->get();
        
        if ($request->session()->has('produit')) {
            $produit=$request->session()->get('produit');
            $qte=$request->session()->get('qte');
            $libelle=$request->session()->get('libelle');
            
            $prdt=Typeproduits::select('id', 'libelle')->whereNotIn('id', $produit)->get();
            
            $res=['prdts' => $prdt,'prdtsall' => $prdts, 'produit' => $produit, 'qte' => $qte, 'libelle' => $libelle, 'pos' =>  $pos];
        }
        
        
        
        return View::make('precommandes.edit')
            ->with($res);
    }
    
    public function stock(Request $request){
      //  $request->session()->flush();
        $p= array();
        $l=array();
        $q=array();
        echo $request->prdt;
        
        if ($request->session()->has('produit')) {
            //var_dump($request->session()->get('produit'));
            $p=$request->session()->get('produit');
            $q=$request->session()->get('qte');
            $l=$request->session()->get('libelle');
        }
        
        array_push($p, $request->prdt);
        array_push($q, $request->qte);
        array_push($l, $request->libelle);
        
        $request->session()->forget('produit');
        $request->session()->forget('qte');
        $request->session()->forget('libelle');
        
        $request->session()->put('produit', $p); //$request->
        $request->session()->put('qte', $q); 
        $request->session()->put('libelle', $l);  
    }
    
     public function destock($id,Request $request){
      //  $request->session()->flush();
        $p=array();
        $q=array();
        
        if ($request->session()->has('produit')) {
            $p=$request->session()->get('produit');
            $q=$request->session()->get('qte');
        }
        
      
        $i= array_search($id, $p); 
        
        array_splice($p, $i,1);
        array_splice($q, $i,1);
        
        $request->session()->forget('produit');
        $request->session()->forget('qte');
        $request->session()->forget('libelle');
        
        $request->session()->put('produit', $p); //$request->
        $request->session()->put('qte', $q); 
        
       // var_dump($value);
     }
    
     public function store(Request $request){

       $currentUser= Auth::user();
       $pos=PointDeVente::findOrFail($currentUser->id_point_de_vente_encours);
       
       $p=array();
       $q=array();
       $data=array();
        
        if ($request->session()->has('produit')) {
            $p=$request->session()->get('produit');
            $q=$request->session()->get('qte');
       
        
        $data["montantverse"]=$request->montantverse;
        $data["statut"]=2;
        $data["id_utilisateur_emetteur"]=$currentUser->id;

        $custom = new CustomFunction();
        $data["numero"] = $custom->NumeroSerie();
        
        
        if($request->posemetteur!="0"){
            $data["id_point_de_vente_destinataire"]=$request->posdest;
            $data["id_point_de_vente_emetteur"]=$request->posemetteur;
        } else if($request->posemetteur=="0") {
            $data["id_point_de_vente_destinataire"]=$pos->parent_id;
            $data["id_point_de_vente_emetteur"]=$pos->id;
        }
       
        $precommande=Precommande::crxeate($data);
      //  var_dump($precommande);
        $i=0;
        foreach($p as $pr){
            $precommande->produits()->attach($pr,['qte' => $q[$i]]);
            $i++;
        }

       $type="success";
       $message="Précommande enregistrée";
       
       $request->session()->forget('produit');
       $request->session()->forget('qte');
       $request->session()->forget('libelle');
       
       $request->session()->flash('message', $message);
       $request->session()->flash('type', $type);
       return redirect('precommandes');
       
       } else{
        $type="danger";
        $message="Précommande non enregistré, veuillez entrer au moins un produit";
        $request->session()->flash('message', $message);
        $request->session()->flash('type', $type);
        
        return redirect('precommandes/edit');   
       }
        
        
    }


    public function validation($id, Request $request){

//	    $request->session()->forget('precommande_reference');
//	    $request->session()->forget('precommande_reference_id');

	        // Création du transfert associé
			$current = $this->modelRepository->getById($id);

		    if(!$request->session()->has('precommande_id')):
			    $request->session()->put('precommande_id', $current->id);
	        else:
		        $precmd_id = $request->session()->get('precommande_id');
		        if($precmd_id !== $current->id):
			        if($request->session()->has('precommande_reference')):
				        $request->session()->forget('precommande_reference');
				        $request->session()->forget('precommande_reference_id');
			        endif;
		        endif;
		    endif;

		    $precommande_reference = [];
		    if($request->session()->has('precommande_reference')):
			    $precommande_reference = $request->session()->get('precommande_reference');
		    endif;


//			$input = array();
//			$input['pos_vendeur'] = $current->id_point_de_vente_destinataire;
//			$input['pos_acheteur'] = $current->id_point_de_vente_emetteur;
//			$input['vendeur'] = Auth::user()->id;
//
//			$qte = 0;
//			$montant = 0;
//
//			foreach ($current->produits as $produit):
//
//				$qte += $produit->pivot->qte;
//
//				if($produit->promo):
//					$inter = $produit->pivot->qte * $produit->prix_promo;
//				else:
//					$inter = $produit->pivot->qte * $produit->prix;
//				endif;
//
//				$montant += $inter;
//
//
//			endforeach;
//
//	        $input['montant'] = $montant;
//	        $input['qte'] = $qte;
//	        $input['precommande_id'] = $id;
//
//	        $transfert = $this->transfertRepository->store($input);
//
//		    foreach ($current->produits as $produit):
//
//					$POS_seller = $this->modelPOS->findOrFail($current->id_point_de_vente_destinataire)
//					                                ->stock()
//					                                ->where('typeproduit_id', '=', $produit->id)
//												    ->where('etat', '=', 0)
//					                                ->orderBy('created_at', 'asc')
//					                                ->limit($produit->pivot->qte)
//			                                        ->get();
//
//				    if($produit->promo):
//					    $inter = $produit->prix_promo;
//				    else:
//					    $inter = $produit->prix;
//				    endif;
//
//
//					foreach ($POS_seller as $prod){
//						$this->transfertRepository->getById($transfert->id)->produits()->save($prod, ['prix' => $inter]);
//						$changeState = $this->modelPOS->findOrFail($current->id_point_de_vente_destinataire)->stock()->where('id', $prod->id)->get()->first();
//						$changeState->pivot->etat = 1;
//						$changeState->pivot->save();
//					}
//
//
//		    endforeach;
//
//		    if($montant):
//
//			    $inputTran = array();
//			    $inputTran['transfert_id'] = $transfert->id;
//			    $inputTran['user_id'] = Auth::user()->id;
//			    $inputTran['montant'] = $montant;
//			    $inputTran['type'] = 0;
//
//			    $this->transactionsRepository->store($inputTran);
//
//		    endif;
//
//			$this->modelRepository->saveValid($current);

	    // redirection

//	    return redirect()->route('precommande.show', ['id' => $id])->withOk("La précommande a été validée.");

	    return view('precommandes.validate', compact('current', 'precommande_reference'));
    }


    public function ValidSearchAddProduct($reference, $id, Request $request){

    	$precommande = $this->modelRepository->getById($id);

    	$products = $this->modelPOS->findOrFail($precommande->id_point_de_vente_destinataire)->stock()->where('reference', 'LIKE', '%' .$reference. '%')->where('etat', '=', 0)->get();

		$data = [
			'produits' => [],
			'one_product' => 0
		];

	    $produits_add_id = array();

	    if($request->session()->has('precommande_reference_id')):
		    $produits_add_id = $request->session()->get('precommande_reference_id');
	    endif;

		foreach ($products as $key => $product):
			$insert = [
				'id' => $product->id,
				'reference' => $product->reference,
				'produit' => $product->type_produit()->first()->libelle
			];

			if(!in_array($product->id, $produits_add_id)):
				$data['produits'][$key] = $insert;
				array_push($produits_add_id, $product->id);
			endif;
		endforeach;

	    $produits_add = array();

	    if($request->session()->has('precommande_reference')):
		    $produits_add = $request->session()->get('precommande_reference');
	    endif;

	    if(count($products) === 1):

		    foreach ($data['produits'] as $inser_pro):
			    if(in_array($inser_pro['id'], $produits_add_id)):
				    array_push($produits_add, $inser_pro);
	            endif;
		    endforeach;

		    $request->session()->put('precommande_reference', $produits_add);
		    $request->session()->put('precommande_reference_id', $produits_add_id);

		    $data['one_product'] = 1;

	    endif;

		return response()->json(['data' => $data]);

    }
    
}
