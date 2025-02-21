<?php

/**
 * Created by Alvaro Alvarez.
 * User: alvaro1
 * Date: 3/6/17
 * Time: 6:18 PM
 *
 * This class verify the coherence in the codification of  Yes/No question and Positive/Negative
 *
 */
namespace Stanford\GoProd;
use \REDCap as REDCap;
include_once 'utilities.php';


// TODO: ADD veriffication Numbers without labels  0,__ 1,__
class check_consistency_for_lists //check_consistency_for_lists
{

//Dictionary of  possible words for Yes or no
    /**
     * @return string --- with the list of possible values for Yes
     */
    public static function getYesWords()
    {
        global $config_json;
        return $config_json['yes_no']['keywords_yes'];
    }

    public static function getNoWords()
    {
        global $config_json;
        return $config_json['yes_no']['keywords_no'];
    }

    //Dictionary of  possible words for Positive Or Negative results

    /**
     * @return string --- with the list of possible values for Positive
     */
    public static function getPositiveWords()
    {
        global $config_json;
        return $config_json['positive_negative']['keywords_positive'];
    }

    /**
     * @return string --- with the list of possible values for  Negative
     */
    public static function getNegativeWords()
    {
        global $config_json;
        return $config_json['positive_negative']['keywords_negative'];
    }


    /**
     * @param $DataDictionary
     * @return array
     * //Get dropdown, Checkbox  and Radio buttons from the REDCap Data Dictionary
     */
    public static function getLists($DataDictionary)
    {
        $var = array();
        // Loop through each field and do something with each
        foreach ($DataDictionary as $field_name => $field_attributes) {
            // Do something with this field if it is a checkbox field
            if ($field_attributes['field_type'] == "yesno" || $field_attributes['field_type'] == "radio" || $field_attributes['field_type'] == "dropdown") {

                $FormName = $field_attributes['form_name'];
                $FieldName = $field_attributes['field_name'];
                $Choices = $field_attributes['select_choices_or_calculations'];
                if ($field_attributes['field_type'] == "yesno") {
                    array_push($var, array($FormName, $FieldName, "1, Yes | 0, No"));
                } else {
                    array_push($var, array($FormName, $FieldName, $Choices));
                }
            }
        }
        return $var;
    }

    /**
     * @param $array
     * @return array
     * //In: Array $FormName,$FieldName,$Choices  --- Return: Array $Form,$Field, Id, Value
     */
    public static function Transform($array)
    {

        $dd_array = array();
        foreach ($array as $item) {
            $form = $item[0];
            $field = $item[1];
            $arrayOptions = explode("|", $item[2]);
            foreach ($arrayOptions as $item2) {
                $arrayOptionsExplode = explode(",", $item2, 2);
                array_push($dd_array, array($form, $field, $arrayOptionsExplode[0], $arrayOptionsExplode[1]));

            }
        }
        return $dd_array;
    }

    /**
     * @param $string
     * @return mixed|string
     */
    public static function CleanString($string)
    {

        // first preparing the strings.
        //for $string1
        //remove spaces at the end and convert in lowercase
        $word1 = trim(strtolower($string));
        //remove spaces between words
        $word1 = str_replace(' ', '_', $word1);
        //remove tabs
        $word1 = preg_replace('/\s+/', '_', $word1);
        $word1 = str_replace('__', '_', $word1);

        return $word1;
    }

    /**
     * @param $array
     * @return array
     */
    public static function CleanArray($array)
    {
        $CleanedArray = array();
        foreach ($array as $item) {
            array_push($CleanedArray, self::CleanString($item));
        }

        return $CleanedArray;
    }

    /**
     * @param $string1
     * @param $string2
     * @param $percentage
     * @return bool
     * Compare two strings and return if they have a similarity bigger than $percentage
     */
    public static function EvaluateSimilarity($string1, $string2, $percentage)
    {

        // first preparing the strings.
        //for $string1
        //remove spaces at the end and convert in lowercase
        $word1 = trim(strtolower($string1));
        //remove spaces between words
        $word1 = str_replace(' ', '_', $word1);
        //remove tabs
        $word1 = preg_replace('/\s+/', '_', $word1);
        $word1 = str_replace('__', '_', $word1);
        // for $string2
        //remove spaces at the end and convert in lowercase
        $word2 = trim(strtolower($string2));
        //remove spaces between words
        $word2 = str_replace(' ', '_', $word2);
        //remove tabs
        $word2 = preg_replace('/\s+/', '_', $word2);
        $word2 = str_replace('__', '_', $word2);
        // obtain the % of similarity betwen words as a number and save the value on $similarity
        similar_text($word1, $word2, $similarity);

        return $similarity >= $percentage ? true : false;

    }


    //Filter just  the yes no questions

    /**
     * @param $array
     * @param $known_list
     * @return array
     */
    public static function Filter($array, $known_list, $percentage = 95)
    {
        $to_fix_array = array();
        $OtherOrUnknownList = explode(",", $known_list);
        foreach ($array as $list) {
            foreach ($OtherOrUnknownList as $Other) {
                if (self::EvaluateSimilarity($list[3], $Other, $percentage)) {   //TODO: check if   substrings should be part of the query or not strpos($list[3],$Other)

                    $table = self::getChoices($array, $list[1], $list[3]);

                    array_push($to_fix_array, array($list[0], $list[1], $list[2], $table));
                }
            }
        }
        return $to_fix_array;
    }


    // create the table with the choices and highlight the  inconsistent one
    public static function getChoices($array, $variable_name, $to_highlight)
    {
        $table = '<table id="gp-results-table" class="table table-sm"  style="width:80%; border-color: inherit;" border="1">';

        foreach ($array as $list) {
            if ($variable_name == $list[1]) {
                if ($to_highlight == $list[3]) {
                    $table .= '<tr><td class="bg-info" style="color: red" ><strong>' . $list[2] . '</strong></td><td class="bg-info" style="color: red"><strong>' . $list[3] . '</strong></td></tr>';

                } else {
                    $table .= '<tr><td>' . $list[2] . '</td><td>' . $list[3] . '</td></tr>';
                }


            }
        }

        return $table .= '</table>';

    }

    //check if any Id (Yes or No ot Positive/Negative) is different  tho the rest

    /**
     * @param $array
     * @return array
     */
    public static function FindProblems($array)
    {
        global $Proj;

        //If we're in production, only looked at drafted changes
        if (projectMode() == "1") {
            $drafted_fields = draftedFields();
            $status = "1";
        } else {
            $status = projectMode();
        }

        //var_dump($array);


        $FilteredOut = array();
        foreach (array_reverse($array) as $item1) {

            foreach ($array as $item2) {
                if ( ( $item1[2] != $item2[2] && !in_array($item1, $FilteredOut))   ) {
                    $link_path1 = APP_PATH_WEBROOT . 'Design/online_designer.php?pid=' . $_GET['pid'] . '&page=' . $item1[0] . '&field=' . $item1[1];
                    $link_path2 = APP_PATH_WEBROOT . 'Design/online_designer.php?pid=' . $_GET['pid'] . '&page=' . $item2[0] . '&field=' . $item2[1];
                    $link_to_edit1 = '<a href=' . $link_path1 . ' target="_blank" ><img src=' . APP_PATH_IMAGES . 'pencil.png></a>';
                    $link_to_edit2 = '<a href=' . $link_path2 . ' target="_blank" ><img src=' . APP_PATH_IMAGES . 'pencil.png></a>';

                    // Adding : Intrument Name, instrument
                    $label1 = TextBreak($item1[1]);
                    $label2 = TextBreak($item2[1]);

                    array_push($FilteredOut, array(REDCap::getInstrumentNames($item1[0]), $item1[1], $label1, $item1[3], $link_to_edit1));
                    array_push($FilteredOut, array(REDCap::getInstrumentNames($item2[0]), $item2[1], $label2, $item2[3], $link_to_edit2));
                    break;
                }
            }
            if (!empty($FilteredOut)) {
                break;
            }
        }



        if (projectMode() == "1") {

            $final_array = array();

            foreach ($FilteredOut as $item) {
                if (!in_array($item[1], $drafted_fields)) {
                    //echo $item[1];
                }
                    //echo $item[1];
//                }
            }
        }



        return  array_map("unserialize", array_unique(array_map("serialize", $FilteredOut))); //return just the unique values found
    }


    /**
     * Check coherence for Yes and No questions
     * @param $DataDictionary
     * @return array
     */
    public static function IsYesNoConsistent() {
        if(projectMode() == "1") {
            $DataDictionary = REDCap::getDataDictionary('array', false, null, null, true);
        } else {
            $DataDictionary = \REDCap::getDataDictionary('array');
        }

        $yes_no_array= self::getLists($DataDictionary);
        $all_list_questions=  self::Transform($yes_no_array);
        $yes_words=self::getYesWords();
        $no_words=self::getNoWords();

        $yes_list= self::Filter($all_list_questions, $yes_words);
        $no_list= self::Filter($all_list_questions, $no_words);

        $yes=self::FindProblems($yes_list);
        $no=self::FindProblems($no_list);
        return array_merge($yes,$no);
    }


    /**
     * Check coherence for positive and negative questions
     * @param $DataDictionary
     * @return array
     */
    public static function IsPositiveNegativeConsistent() {
        if(projectMode() == "1") {
            $DataDictionary = REDCap::getDataDictionary('array', false, null, null, true);
        } else {
            $DataDictionary = \REDCap::getDataDictionary('array');
        }

        $positive_negative_array= self::getLists($DataDictionary);
        $all_list_questions=  self::Transform($positive_negative_array);
        $positive_words=self::getPositiveWords();
        $negative_words=self::getNegativeWords();

        $positive_list= self::Filter($all_list_questions, $positive_words);
        $negative_list= self::Filter($all_list_questions, $negative_words);

        $positive=self::FindProblems($positive_list);
        $negative=self::FindProblems($negative_list);
        return array_merge($positive,$negative);
    }


}