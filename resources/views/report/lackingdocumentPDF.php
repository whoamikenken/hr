<?php
ini_set("pcre.backtrack_limit", "5000000");
$pdf = new \Mpdf\Mpdf(array('mode' => 'utf-8', 'format' => 'LETTER-L', 'orientation' => 'L'));
$pdf->SetTitle($reportName);

$info  = "  <style>
                @page{            
                    /*margin-top: 4.35cm;*/
                    margin-top: 3.15cm;
                    odd-header-name: html_Header;
                    odd-footer-name: html_Footer;
                }
                th{
                	color: white;
                }  
                .content{
                    height: 100%;
                    margin-top: 15px;
                }
                table{
                    border-collapse: collapse;
                    font-size: 12px;
                    border-spacing: 5px;
                }
                .content-header{
                    text-align: center;
                    font-size: 12px;
                }
                .content-body{
                    border: 1px solid black;
                    padding-top: 8px;
                    padding-bottom: 8px;
                    padding-left: 8px;
                }

			    .footer{
			    	width: 100%;
			    	text-align: right;
			    }
            </style>";
$info .= "
<htmlpageheader name='Header'>
    <div>
        <table width='60%'  >
            <tr>
                <td rowspan='4' style='text-align: right;' width='60%'><img src='images/logo.png' style='width: 70px;text-align: center;' /></td>
                <td valign='middle' width='90%' style='padding: 0;text-align: center;' width='45%'><span style='font-size: 13px;'><b>KINGS MANPOWER SERVICES</b></span></td>
            </tr>
            <tr>
                <td valign='middle' style='padding: 0;text-align: center;'><span style='font-size: 13px;' width='45%'><strong>Envision and achieve an optimum goal
</strong></span></td>
            </tr>
            <tr>
                <td valign='middle' style='padding: 0;text-align: center;'><span style='font-size: 13px;' width='45%'><strong>" . $reportName . "</strong></span></td>
            </tr>
            <tr>
                <td valign='middle' style='padding: 0;text-align: center;'><span style='font-size: 11px;' width='45%'><strong></strong>" . $dateof . "</span></td>
            </tr>
        </table>
    </div>
</htmlpageheader>";
$info .= "

<div class='content'>
    <div class='content-header'>
        <table border=1 width='100%' style='font-size: 9px;' id='datas'>
            <thead>
            <tr style='background-color: black;'>
            ";
            $info .= "<th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Name</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Applicant ID</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>ER #</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>MAID #</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Face Photo</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Body Photo</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Video</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>PDOS</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>OWWA</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>E-Reg</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>OFW Infosheet</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>EC/ID988A</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>EC pt6 p4</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>COE</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>HQ</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>MMR Vaccination</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Infosheet</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Privacy Policy</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Affidavit</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>COVID DEC</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Preg Test</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Swab Test</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Insurance</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Diploma</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>Driver License</th>
            <th style='padding: 5px;text-align: center;font-size: 12px;font-weight: bold;'>PRC</th>
            </tr>";

$info .= "</thead>";
$info .= "<tbody>";
// dd($result);
if (count($result) > 0) {
    foreach ($result as  $value) {
        $value = (object) $value;
        // CERTIFICATES
        $value->cert_ereg = ($value->cert_ereg) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->cert_peos = ($value->cert_peos) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->cert_pdos = ($value->cert_pdos) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->cert_owwa = ($value->cert_owwa) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->cert_nc2 = ($value->cert_nc2) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->cert_ofw_infosheet = ($value->cert_ofw_infosheet) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';

        // SUPPORTING DOCUMENT
        $value->sup_doc_id988a = ($value->sup_doc_id988a) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->sup_pt6 = ($value->sup_pt6) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->sup_coe = ($value->sup_coe) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->sup_hq = ($value->sup_hq) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->sup_polohk = ($value->sup_polohk) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->sup_infosheet = ($value->sup_infosheet) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->sup_privacy_policy = ($value->sup_privacy_policy) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->sup_affidavit = ($value->sup_affidavit) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->sup_mmr_vac = ($value->sup_mmr_vac) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->cert_prc = ($value->cert_prc) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->cert_driver_license = ($value->cert_driver_license) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';

        // OEC DOCUMENT
        $value->oec_covid_dec = ($value->oec_covid_dec) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->oec_insurance = ($value->oec_insurance) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->oec_pregnancy_test = ($value->oec_pregnancy_test) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->oec_swab_test = ($value->oec_swab_test) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';

        // MEDICAL DOCUMENT
        $value->med_first_cert = ($value->med_first_cert) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->med_second_cert = ($value->med_second_cert) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->med_third_cert = ($value->med_third_cert) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
        $value->med_fourth_cert = ($value->med_fourth_cert) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';

        // Photo
        $value->user_profile = ($value->user_profile) ? '<b style="color:green">Uploaded</b>' : '<b style="color:red">Not Found</b>';
        $value->user_profile_face = ($value->user_profile_face) ? '<b style="color:green">Uploaded</b>' : '<b style="color:red">Not Found</b>';
        $value->user_video = ($value->user_video) ? '<b style="color:green">Uploaded</b>' : '<b style="color:red">Not Found</b>';

        // DIPLOMA
        $value->diploma = ($value->diploma) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';


        $info .= "<tr>";
        $info .= "<td style='padding: 2px;text-align: center;font-size: 13px;'>".$value->lname . " " . $value->fname . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" .$value->applicant_id. "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->er_ref . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->maid_ref . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" .$value->user_profile_face. "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->user_profile . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->user_video . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->cert_pdos . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->cert_owwa . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->cert_ereg . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->cert_ofw_infosheet . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->sup_doc_id988a . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->sup_pt6 . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->sup_coe . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->sup_hq . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->sup_mmr_vac . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->sup_infosheet . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->sup_privacy_policy . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->sup_affidavit . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->oec_covid_dec . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->oec_pregnancy_test . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->oec_swab_test . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->oec_insurance . "</td>
        <td style='padding: 2px;text-align: center;font-size: 13px;'>" . $value->diploma . "</td>
        ";

        $info .= "</tr>";
    }
} else {
    $info .= "<tr><td colspan='24' style='text-align:center;font-size:20px;'>No Data</td></tr>";
}

// echo $info; die;
$info .= "      
            </tbody>
        </table>
    </div>
</div>";
$info .= "
	<htmlpagefooter name='Footer'>
		<br>
		<div class='footer'>
			Page : {PAGENO} of {nb}
		</div>
	</htmlpagefooter>
";
$pdf->WriteHTML($info);

$pdf->Output($reportName . '.pdf', 'I');
