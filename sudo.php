<?php
$sudo =array(
array(5, 3, 0, 0, 7, 0, 0, 0, 0),
array(6, 0, 0, 1, 9, 5, 0, 0, 0),
array(0, 9, 8, 0, 0, 0, 0, 6, 0),
array(8, 0, 0, 0, 6, 0, 0, 0, 3),
array(4, 0, 0, 8, 0, 3, 0, 0, 1),
array(7, 0, 0, 0, 2, 0, 0, 0, 6),
array(0, 6, 0, 0, 0, 0, 2, 8, 0),
array(0, 0, 0, 4, 1, 9, 0, 0, 5),
array(0, 0, 0, 0, 8, 0, 0, 7, 9)
);
$i = 1;
$num = 0;
get_sudo($sudo, $num, $i);
// var_dump($sudo);
var_dump($i);
var_dump(json_encode($sudo));die;

function get_sudo(&$sudo, &$sum, &$i){
	foreach ($sudo as $r =>$value) {
		foreach($value as $c=>$v){
			if($v==0){
				$pos = find_possibilities($r,$c, $sudo);
				if(count($pos)==1){
					$sudo[$r][$c]= current($pos);
					$sum = $sum+$sudo[$r][$c];
				}
			}else if($i==1){
				$sum = $sum+$sudo[$r][$c];
			}
		}
	}

	$i++;
	if($i/100==0){
		var_dump($i);
	}
	if($sum < 405){
		get_sudo($sudo, $sum, $i);
	}
}


//查找可能数字
function find_possibilities($row, $column, $sudo){
	$ro = get_row($row, $sudo);
	$co = get_column($column, $sudo);
	$bo = get_box($row, $column, $sudo);
	//求交集
	$po = array_intersect($ro, $co, $bo);
	return $po;
}

//获取行的可能性
function get_row($row,$sudo){
	$ro = array();
	for($r = 1; $r<=9; $r++){
		if(!in_array($r, $sudo[$row]))
			$ro[] = $r;
	}
	return $ro;
}

//获取列的可能值
function get_column($column,$sudo){
	$co = array(1,2,3,4,5,6,7,8,9);
	for($r =0; $r<9; $r++ ){
		$temp = $sudo[$r][$column];
		if($temp>0)
			unset($co[$temp-1]);
	}
	return $co;

}

//获取方格的可能性
function get_box($row, $column, $sudo){
	if($row<9)
		$start_x = 6;
	if($row<6)
		$start_x = 3;
	if($row<3)
		$start_x = 0;

	if($column<9)
		$start_y = 6;
	if($column<6)
		$start_y = 3;
	if($column<3)
		$start_y = 0;
	$box = array(1,2,3,4,5,6,7,8,9);
	for($r=$start_x; $r<($start_x+3); $r++){
		for ($c=$start_y; $c < ($start_y+3); $c++) { 
			$temp = $sudo[$r][$c];
			if($temp>0)
				unset($box[$temp-1]);
		}
	}
	return $box;

}

