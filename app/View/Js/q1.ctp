<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover" id="tab1">
<thead>
<th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>Unit Price</th>
</thead>

<tbody>
	<!--
	<tr>
		<td></td>
		<td><textarea name="data[1][description]" class="m-wrap  description required" rows="2" ></textarea></td>
		<td><input name="data[1][quantity]" class=""></td>
		<td><input name="data[1][unit_price]"  class=""></td>
	</tr>
	-->

	<tr>
		<td></td>
		<td>Row 1 Description</td>
		<td>Row 1 QTY</td>
		<td>Row 1 Price</td>
	</tr>

</tbody>

</table>


<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="/video/q3_2.mov">
Your browser does not support the video tag.
</video>
</p>





<?php $this->start('script_own');?>
<script>
$(document).ready(function(){

	var counter = 1;

	$("#add_item_button").click(function(event){
		
		//alert("suppose to add a new row");
		
		event.preventDefault();
	    counter++;
	    
	    var newRow = jQuery('<tr><td></td><td><textarea name="data['+counter+'][description]" class="m-wrap  description required" rows="2" ></textarea></td><td><input name="data['+counter+'][quantity]" class=""></td><td><input name="data['+counter+'][unit_price]"  class=""></td></tr>');
	    
	    /*
	    var newRow = jQuery('<tr><td></td><td>Row '+counter+' Description</td><td>Row '+counter+' Qty</td><td>Row '+counter+' Price</td></tr>');
	    */
	    jQuery('table').append(newRow);

		});

	function getStyle(el, cssprop) {
	if (el.currentStyle)
		return el.currentStyle[cssprop];	 // IE
	else if (document.defaultView && document.defaultView.getComputedStyle)
		return document.defaultView.getComputedStyle(el, "")[cssprop];	// Firefox
	else
		return el.style[cssprop]; //try and get inline style
}

function applyEdit(tabID, editables) {
	var tab = document.getElementById(tabID);
	if (tab) {
		var rows = tab.getElementsByTagName("tr");
		for(var r = 0; r < rows.length; r++) {
			var tds = rows[r].getElementsByTagName("td");
			for (var c = 0; c < tds.length; c++) {
				if (editables.indexOf(c) > -1)
					tds[c].onclick = function () { beginEdit(this); };
			}
		}
	}
}
var oldColor, oldText, padTop, padBottom = "";
function beginEdit(td) {

	if (td.firstChild && td.firstChild.tagName == "INPUT")
		return;

	oldText = td.innerHTML.trim();
	oldColor = getStyle(td, "backgroundColor");
	padTop = getStyle(td, "paddingTop");
	padBottom = getStyle(td, "paddingBottom");

	var input = document.createElement("input");
	input.value = oldText;

	//// ------- input style -------
	var left = getStyle(td, "paddingLeft").replace("px", "");
	var right = getStyle(td, "paddingRight").replace("px", "");
	input.style.width = td.offsetWidth - left - right - (td.clientLeft * 2) - 2 + "px";
	input.style.height = td.offsetHeight - (td.clientTop * 2) - 2 + "px";
	input.style.border = "0px";
	input.style.fontFamily = "inherit";
	input.style.fontSize = "inherit";
	input.style.textAlign = "inherit";
	input.style.backgroundColor = "LightGoldenRodYellow";

	input.onblur = function () { endEdit(this); };

	td.innerHTML = "";
	td.style.paddingTop = "0px";
	td.style.paddingBottom = "0px";
	td.style.backgroundColor = "LightGoldenRodYellow";
	td.insertBefore(input, td.firstChild);
	input.select();
}
function endEdit(input) {
	var td = input.parentNode;
	td.removeChild(td.firstChild);	//remove input
	td.innerHTML = input.value;
	if (oldText != input.value.trim() )
		td.style.color = "blue";

	td.style.paddingTop = padTop;
	td.style.paddingBottom = padBottom;
	td.style.backgroundColor = oldColor;
}
applyEdit("tab1", [1, 2, 3]);
	
});
</script>
<?php $this->end();?>

