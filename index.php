<!DOCTYPE HTML>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="author" content="https://github.com/andrew-h-siberian/Squares_test/ (andrew_h_siberian@rambler.ru)" />
  <link href="style.css" rel="stylesheet" />
  <title>Тестовое задание ("Квадраты")</title>
</head>

<body>
  <div class="main_wrapper">
    <form action="index.php" method="GET">
      <div class="form_div">
        <label for="mSize">m (ПО ГОРИЗОНТАЛИ):</label>
        <input type="number" class="numInput" id="m" name="mSize" min="1" max="50" maxlength="2" required="required" />
        <br/>
        <label for="nSize">n (по вертикали):</label>
        <input type="number" class="numInput" id="n" name="nSize" min="1" max="50" maxlength="2" required />
      </div>
      <div class="form_div">
        <button class="button positive" id="btnCreate" name="fillButton" value="fill" autofocus>Сгенерировать и решить</button>
      </div>
    </form>

    <div class="output_field" id="output1">

      <?php

    echo '<br/>';
    
    function makeGrid($x, $y) {
      echo '<table id="result" border="1px">';
      for($i=1;$i<=$y;$i++) {
        echo '<tr height="26px">';
        for($j=1;$j<=$x;$j++) {
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
    
    function generateValues($y, $x){
      global $array;
      for($i=1;$i<=$y;$i++) {
        for($j=1;$j<=$x;$j++) {
          $array[$i-1][$j-1]=rand(0,1);
        }
      }
    }

    function makeTable($y, $x, $valuesArray){
      echo '<table id="result" border="1px">';
      for($i=1;$i<=$y;$i++) {
        echo '<tr height="26px">';
        for($j=1;$j<=$x;$j++) {
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

    //передадим массив (копию) одним из параметров
    function checkSizeFrom($i,$j,$nSize,$mSize,$array){
      
      $iLimit = $nSize - $i + 1;
      $jLimit = $mSize - $j + 1;
      $limit = ($iLimit<$jLimit) ? $iLimit : $jLimit;
      //echo "limit for i=$i and j=$j is $limit";
      for($size=1;$size<$limit;$size++) {

        $iCheck = $i + $size;
        for($jCheck=$j;$jCheck<=($j+$size);$jCheck++) {
          if($array[$iCheck-1][$jCheck-1]==0) return $size;
          
        }
        
        $jCheck = $j + $size;
        for($iCheck=$i;$iCheck<=($i+$size-1);$iCheck++) {
          if($array[$iCheck-1][$jCheck-1]==0) return $size;
        }
        
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

    if(isset($_GET['fillButton'])){
      generateValues($nSize, $mSize);
      makeTable($nSize, $mSize, $array);
    }
    
    if(isset($_GET['fillButton'])){
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
      echo "<br/><b>Наибольший квадрат состоящий из единиц на данном поле<br/>имеет размеры $maxSize x $maxSize</b><br/>";
      if($maxSize>0) echo "<b>Координаты его верхнего левого угла: n = $nIndex и m = $mIndex</b>";
    }
    
    ?>

    </div>

  </div>

</body>

</html>