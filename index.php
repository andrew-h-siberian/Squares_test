<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Andrew Kharchenko, andrew_h_siberian@rambler.ru" />

	<link href="style.css" rel="stylesheet" />
	
	<title>Тестовое задание ("Квадраты")</title>
	
</head>

<body>
	<!--<form action="index.php" onsubmit="return false" method="GET">-->
	<form action="index.php" method="GET">
		<div class="form_div">
			<label for="mSize">m (по горизонтали):</label>
			<input type="number" class="numInput" id="m" name="mSize" min="1" max="50" maxlength="2"  required="required" />
			<br/>
			<label for="nSize">n (по вертикали):</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="number" class="numInput" id="n" name="nSize" min="1" max="50" maxlength="2" required />
		</div>
		<div class="form_div">
			<input type="submit" class="button positive" id="btnCreate" name="create" value="Create" autofocus/>
			
			<!--<button onclick="fill()" accept="" accesskey="" alt="" formaction="" id="btnCreate" name="fill" value="Заполнить"/>Заполнить</button>-->
			<button class="button positive" id="btnCreate" name="fillButton" value="fill" alt="Заполнить"/>Заполнить</button>
			<input onclick="" type="button" class="button positive" id="btnSolve" name="solve" value="solve" />
		</div>
	</form>
	
    <div class="output_field" id="output1">
	
		<?php
		
		echo '$_GET=' . print_r ($_GET, true);
		echo '<br/>';
		
		function makeGrid($x, $y) {
			echo '<table id="result" border="1px">';
			for($i=1;$i<=$y;$i++) {
				echo '<tr height="26px">';
				for($j=1;$j<=$x;$j++) {
					//echo "m = " . $i . " and n = " . $j . "<br/>";
					$cellClassNum = 1;
					if(($i+$j)%2==1) $cellClassNum = 2;
					echo "<td class=\"cell$cellClassNum\" width=\"26px\">";
					echo '0';
					echo '</td>';
				}
				echo '</tr>';
			}
			echo '</table>';
		}
		
		function generateValues($x, $y){
			global $array;
			for($i=1;$i<=$y;$i++) {
				for($j=1;$j<=$x;$j++) {
					$array[$i-1][$j-1]=rand(0,1);
				}
			}
		}

		function makeTable($x, $y, $valuesArray){
			echo '<table id="result" border="1px">';
			for($i=1;$i<=$y;$i++) {
				echo '<tr height="26px">';
				for($j=1;$j<=$x;$j++) {
					//echo "m = " . $i . " and n = " . $j . "<br/>";
					$cellClassNum = 1;
					if(($i+$j)%2==1) $cellClassNum = 2;
					echo "<td class=\"cell$cellClassNum\" width=\"26px\"><b>";
					echo $valuesArray[$i-1][$j-1];
					echo '</b></td>';
				}
				echo '</tr>';
			}
			echo '</table>';
		}

		//а здесь для разнообразия (опыта) передадим массив (копию) одним из параметров
		function checkSizeFrom($i,$j,$nSize,$mSize,$array){
			
			$iLimit = $nSize - $i + 1;
			$jLimit = $mSize - $j + 1;
			$limit = ($iLimit<$jLimit) ? $iLimit : $jLimit;
			//echo "limit for i=$i and j=$j is $limit";
			for($size=1;$size<$limit;$size++) {
				//if($size=$limit) return $size; // ***CHECK*** if this is ok
				
				$iCheck = $i + $size;
				for($jCheck=$j;$jCheck<=($j+$size);$jCheck++) {
					if($array[$iCheck-1][$jCheck-1]==0) return $size;
					
				}
				
				$jCheck = $j + $size;
				for($iCheck=$i;$iCheck<=($i+$size-1);$iCheck++) {
					if($array[$iCheck-1][$jCheck-1]==0) return $size;
				}
				
				//if($size=$limit) return $size; //just return $size if condition in for loop is <$limit
			}
			return $size;
		}
		
		if (!isset($_GET['mSize'])){
			$mSize = 10;
		} else {
			$mSize = $_GET['mSize'];
			if($mSize > 50) $mSize = 50;
			if($mSize < 1) $mSize = 1;
		}

		if (!isset($_GET['nSize'])){
			$nSize = 10;
		} else {
			$nSize = $_GET['nSize'];
			if($nSize > 50) $nSize = 50;
			if($nSize < 1) $nSize = 1;
		}

		$array = array();
		
		//вообще стоило сделать m - "вертикалью", а n "горизонталью", но уже взяли m и n "по геометрическому",
		//как x и y (сначала "горизонталь", потом "вертикаль"), будем в циклах обходить сначала n, потом m
		
		if(isset($_GET['create'])) makeGrid($nSize, $mSize);
		
		if(isset($_GET['fillButton'])){
			//makeGrid($mSize, $nSize);
			generateValues($nSize, $mSize);
			makeTable($nSize, $mSize, $array);
		}
		
		if(isset($_GET['solve'])){
			$maxSize = 0;
			$nIndex=0;
			$mIndex=0;
			//начнем обходить массив в поисках первой попавшейся единицы
			for($i=1;$i<=$nSize-$maxSize;$i++){
				for($j=1;$j<=$mSize-$maxSize;$j++){
					//если найдем - начнем проверять размер квадрата с этой позиции
					if($array[$i-1][$j-1] == 1) {
						if($maxSize==0) $maxSize=1;
						$size=checkSizeFrom($i,$j,$nSize,$mSize,$array);
						if($size>$maxSize) {
							$maxSize = $size;
							$nIndex = $i;
							$mIndex = $j;
						}
					}
				}
				
			}
			echo "Наибольший квадрат состоящий из единиц на данном поле<br/>имеет размеры $maxSize x $maxSize<br/>";
			if($maxSize>0) echo "Координаты его верхнего левого угла: n = $nIndex и m = $mIndex";
		}
		
		?>
		
	</div>
	
	<!--<script>
		document.write("1a2b3c".match(/[0-9]*/));
		var numInputElements = document.getElementsByClassName("numInput");
		for(var e of numInputElements) {
			//e.addEventListener("keyup", valNum(e));
			//e.addEventListener("keyup", valNum(e));
			e.addEventListener("keypress", function(evt) {
				console.log("Key pressed: " + evt.charCode + " - " + evt.keyCode);
				var keycode = evt.charCode || evt.keyCode;
				//if (keycode == 46 || this.value.length==3) {
				console.log(typeof e);
				console.log(e);
				console.log(e.value);
				if(isNaN(e.value)){
					e.value=e.value.match(/[0-9]*/);
					console.log("hello!!! " + e.value);
					return false;
				}
			});
		}
		
	/*	on("keypress", function(evt) {
	  var keycode = evt.charCode || evt.keyCode;
	  if (keycode == 46 || this.value.length==3) {
		return false;
	  }
	});*/
		
		//function valNum(x){
		//	//var e = document.getElementById(x);
		//	if(isNaN(x.val())){
		//		document.write(x);
		//		x.val(x.val().match(/[0-9]*/));
		//	}
		//}
		
		//left as an example of regexp little flaw
		//keyup(function() {
		//	var e = document.getElementById("m");
		//	if(isNaN(e.val())){
		//		e.val(e.val().match(/[0-9]*/)); //so, why not to hate regexp when they can contain "end of multiline commentary section" set of characters? :)
		//	}
		//});
		
	</script>-->
	
</body>
</html>