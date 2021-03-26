<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 1:52 PM
 */


namespace Stanford\GoProd;

function InstrumentVariableLabelToHTML($instrument,$VariableName,$Label){

    return '<table class="gp-label-table">
                <tr>
                    <td><strong>'.lang('INSTRUMENT').'</strong></td>
                    <td >'.$instrument.'</td>
                </tr>
                <tr>
                    <td><strong>'.lang('VARIABLE_NAME').'</strong></td>
                    <td>'.$VariableName.'</td>
                </tr>
                <tr >
                    <td><strong>'.lang('LABEL').'</strong></td>
                    <td>'.$Label.'</td>
                </tr>
         </table>';

}

/**
 * @param $array
 * @return array
 */
function TransformToThreeColumnsTable($array){
    $tmp=array();
         $tmp[]=InstrumentVariableLabelToHTML($array[0],$array[1],$array[2]); //where is
        $tmp[]=$array[3];//error
        $tmp[]=$array[4];// link
       return $tmp;
}

/**
 * @param $results
 * @return array
 */
function TransformToThreeColumns($results){
    $arr=array();
    foreach ($results as $item ){
            array_push($arr, TransformToThreeColumnsTable($item));
       }
//     error_log( "RULE EN 1:::::::::::::::::");
//      error_log( print_r($arr , TRUE));
//     error_log( ":::::::::::::::::::::::::::::::::::::::::::::::::::::::::::");
    return $arr;
}

//tiene que retornar en $Rule['results'] un array con datos o vacio si es positivo  o false si no se encotro el problema
function OtherOrUnknown(){
    global $config_json;

    $Rule['title']=lang('OTHER_OR_UNKNOWN_TITLE');
    $Rule['body']=lang('OTHER_OR_UNKNOWN_BODY');
    $Rule['risk']=$config_json['other_or_unknown']['type']; // level of risk: warning, danger or info.
//    $Rule['status'] //actvie- inactive -skiped
    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_other_or_unknown.php';
    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_other_or_unknown();

    $Rule['results']=TransformToThreeColumns($res::CheckOtherOrUnknown());

//    if(empty($Rule['results'])){
//        $Rule['results']=false;
//    }
    return $Rule;

}