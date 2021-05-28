<?php
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
        return $arr;
    }