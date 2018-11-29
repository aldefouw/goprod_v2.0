<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 2018-11-28
 * Time: 12:46
 */

namespace Stanford\GoProd;


class CreateRuleHelper
{


    var  $title;
    var  $body;
    var  $risk;
    var  $results;
    var  $where;
    var  $issue;
    var  $link;

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @param mixed $risk
     */
    public function setRisk($risk)
    {
        $this->risk = $risk;
    }

    /**
     * @param mixed $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

    /**
     * @param mixed $where
     */
    public function setWhere($where)
    {
        $this->where = $where;
    }

    /**
     * @param mixed $issue
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }



    /***************************************************************************************
     * The functions below are in chagrge of printing, and adding the HTML to the rules
     *
     * (probably in the future this group of functions will be moved to an external class)
     *
     ************************************************************************************** */

    public function PrintTr($title_text,$body_text,$span_label,$a_tag,$rulename){
        $value=
            '<tr class="gp-tr" id="'.$rulename.'" style="display: none">
            <td class="gp-info-content">
                <div class="gp-title-content gp-text-color">
                      <b>'.$title_text.' </b> 
                     <span class="title-text-plus" style="color: #7ec6d7"><small>(hide)</small></span> 
                </div>
                    
                <div class="gp-body-content overflow  gp-text-color" >
                    <p class="list-group-item-text" >
                        ' .$body_text.' 
                    </p>
                </div>
            </td>
            <td class="center " width="100">               
                    '.$span_label.' 
            </td>
            <td class="gp-actions center" width="100">               
                 <div class="gp-actions-link" style="display: none">'.$a_tag.'</div>    
            </td>
        </tr>';
        // $value=htmlentities(stripslashes(utf8_encode($value)), ENT_QUOTES);
        return $value;
    }
//Print the level of risk or the rule
    public  function PrintLevelOfRisk($type){
        $size='fa-2x';
        switch ($type) {

            case "warning":
                $risk_title=lang('WARNING');
                $risk_color='text-warning';
                //$risk_icon='glyphicon glyphicon-exclamation-sign';
                $risk_icon='fa fa-exclamation-triangle';
                break;
            case "danger":
                $risk_title=lang('DANGER');
                $risk_color='text-danger';
                $risk_icon='fa fa-fire';
                break;
            case "success":
                $risk_title=lang('SUCCESS');
                $risk_color='text-success';
                $risk_icon='fa fa-thumbs-up';
                $size='fa-5x';
                break;
            case "info":
                $risk_title=lang('INFO');
                $risk_color='text-info';
                $risk_icon='fa fa-info-circle';
                break;
            default: //just in case
                $risk_title=lang('INFO');
                $risk_color='text-info';
                $risk_icon='fa fa-info-circle';
        }
        return '<abbr title='.$risk_title.'><span class="'.$size.' '.$risk_icon.' '.$risk_color.'" aria-hidden="true"></span></abbr>';
    }
    public  function PrintAHref($link_to_view){
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode($link_to_view);
        return '<a href="#ResultsModal" role="button"   class="btn  btn-default btn-lg review_btn" data-toggle="modal" data-link='.$link.' data-is-loaded="false">'.lang('VIEW').'</a>';
    }




    public function RenderRule($ResultRulesArray, $RuneName){

        $a=PrintAHref("views/results.php");// results.php is the DATA TABLE that shows the list of issues
        $span=PrintLevelOfRisk($ResultRulesArray['risk']);
        $print=PrintTr($ResultRulesArray['title'],$ResultRulesArray['body'],$span,$a,$RuneName);
        $ResultRulesArray=$ResultRulesArray['results'];
        $result[$RuneName]= array("Results"=>$ResultRulesArray,"Html"=>$print);
        $res = json_encode($result);
        return $res;
    }



}