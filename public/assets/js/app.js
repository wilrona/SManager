// (function ($) {
//     "use strict";
//     function $fixBootstrapModalPosition() {
//         $(this).css('display', 'block');
//         var $dialog  = $(this).find(".modal-dialog"),
//             offset       = ($(window).height() - $dialog.height()) / 3,
//             bottomMargin = parseInt($dialog.css('marginBottom'), 10);
//
//         // Make sure you don't hide the top part of the modal w/ a negative margin if it's longer than the screen height, and keep the margin equal to the bottom margin of the modal
//         if(offset < bottomMargin) offset = bottomMargin;
//         $dialog.css("margin-top", offset);
//     }
//
//     $(document).on('show.bs.modal', '.modal', $fixBootstrapModalPosition);
//     $(window).on("resize", function () {
//         $('.modal:visible').each($fixBootstrapModalPosition);
//
//     });
// })(jQuery);


var oTable_3 = $('.sample_3').dataTable({
    "aoColumnDefs" : [{
        "aTargets" : [0]
    }],
    "oLanguage" : {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage de  _START_ &agrave; _END_ sur _TOTAL_ ",
        "sInfoEmpty":      "Affichage de 0 &agrave; 0 sur 0 ",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible",
        "oPaginate": {
            "sFirst":      "",
            "sPrevious":   "",
            "sNext":       "",
            "sLast":       ""
        },
        "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
    },
    "aaSorting" : [[0, 'asc']],
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tous"], // change per page values here
    ],
    // set the initial value
    "iDisplayLength" : 10,
    "searching": false,
});
$('#sample_3_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
// modify table search input
$('#sample_3_wrapper .dataTables_length select').addClass("m-wrap small");
// modify table per page dropdown
$('#sample_3_wrapper .dataTables_length select').wrap("<div class='clip-select inline-block'></div>");
// add custom class to select dropdown
$('#sample_3_column_toggler input[type="checkbox"]').change(function() {
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
    var iCol = parseInt($(this).attr("data-column"));
    var bVis = oTable_3.fnSettings().aoColumns[iCol].bVisible;
    oTable_3.fnSetColumnVis(iCol, ( bVis ? false : true));
});

var oTable_4 = $('.sample_4').dataTable({
    "aoColumnDefs" : [{
        "aTargets" : [0]
    }],
    "oLanguage" : {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage de  _START_ &agrave; _END_ sur _TOTAL_ ",
        "sInfoEmpty":      "Affichage de 0 &agrave; 0 sur 0 ",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible",
        "oPaginate": {
            "sFirst":      "",
            "sPrevious":   "",
            "sNext":       "",
            "sLast":       ""
        },
        "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
    },
    "aaSorting" : [[0, 'asc']],
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tous"], // change per page values here
    ],
    // set the initial value
    "iDisplayLength" : 10,
    "searching": false,
});
$('#sample_4_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
// modify table search input
$('#sample_4_wrapper .dataTables_length select').addClass("m-wrap small");
// modify table per page dropdown
$('#sample_4_wrapper .dataTables_length select').wrap("<div class='clip-select inline-block'></div>");
// add custom class to select dropdown
$('#sample_4_column_toggler input[type="checkbox"]').change(function() {
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
    var iCol = parseInt($(this).attr("data-column"));
    var bVis = oTable_4.fnSettings().aoColumns[iCol].bVisible;
    oTable_4.fnSetColumnVis(iCol, ( bVis ? false : true));
});


var oTable_5 = $('.sample_5').dataTable({
    "aoColumnDefs" : [{
        "aTargets" : [0]
    }],
    "oLanguage" : {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche :",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage de  _START_ &agrave; _END_ sur _TOTAL_ ",
        "sInfoEmpty":      "Affichage de 0 &agrave; 0 sur 0 ",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible",
        "oPaginate": {
            "sFirst":      "",
            "sPrevious":   "",
            "sNext":       "",
            "sLast":       ""
        },
        "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
    },
    "aaSorting" : [[0, 'asc']],
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tous"], // change per page values here
    ],
    // set the initial value
    "iDisplayLength" : 10,
    "searching": true
});
$('#sample_5_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
// modify table search input
$('#sample_5_wrapper .dataTables_length select').addClass("m-wrap small");
// modify table per page dropdown
$('#sample_5_wrapper .dataTables_length select').wrap("<div class='clip-select inline-block'></div>");
// add custom class to select dropdown
$('#sample_5_column_toggler input[type="checkbox"]').change(function() {
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
    var iCol = parseInt($(this).attr("data-column"));
    var bVis = oTable_5.fnSettings().aoColumns[iCol].bVisible;
    oTable_5.fnSetColumnVis(iCol, ( bVis ? false : true));
});