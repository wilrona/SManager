$(function () {
    var
        $table = $('#tree-table'),
        rows = $table.find('tr');
		children2 = $table.find('tr[data-level="2"]');
		children1 = $table.find('tr[data-level="1"]');

    rows.each(function (index, row) {
        var
            $row = $(row),
            level = $row.data('level'),
            id = $row.data('id'),
            $columnName = $row.find('td[data-column="name"]'),
            children = $table.find('tr[data-parent="' + id + '"]');
            
			 

        if (children.length) {
		 
			if(level=="1"){
				var expander = $columnName.prepend('' +
                '<span class="treegrid-expander glyphicon glyphicon-chevron-down"></span>' +
                '');
			} else {
			 var expander = $columnName.prepend('' +
                '<span class="treegrid-expander glyphicon glyphicon-chevron-right"></span>' +
                '');
				
			}
			

            children.hide();
			// children2.show();

            expander.on('click', function (e) {
			console.log(e);
                var $target = $(e.target);
                if ($target.hasClass('glyphicon-chevron-right')) {
                    $target
                        .removeClass('glyphicon-chevron-right')
                        .addClass('glyphicon-chevron-down');

                    children.show();
                } else {
                    $target
                        .removeClass('glyphicon-chevron-down')
                        .addClass('glyphicon-chevron-right');

                    reverseHide($table, $row);
                }
            });
        }

        $columnName.prepend('' +
            '<span class="treegrid-indent" style="width:' + 15 * level + 'px"></span>' +
            '');
    });

    // Reverse hide all elements
    reverseHide = function (table, element) {
        var
            $element = $(element),
            id = $element.data('id'),
            children = table.find('tr[data-parent="' + id + '"]');

        if (children.length) {
            children.each(function (i, e) {
                reverseHide(table, e);
            });

            $element
                .find('.glyphicon-chevron-down')
                .removeClass('glyphicon-chevron-down')
                .addClass('glyphicon-chevron-right');
			
            children.hide();
			// children2.show();
        }
    };
	
	//children1.show();
	children2.show();
	var columnName1 = children1.find('td[data-column="name"]');
	/*console.log(columnName1);
	columnName1.removeClass('glyphicon-chevron-right');
	columnName1.prepend('' +
     '<span class="treegrid-expander glyphicon glyphicon-chevron-down"></span>' +
     '');*/
});
