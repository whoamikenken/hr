<?php

use App\Models\Extras;

$pdf = new \Mpdf\Mpdf(array('mode' => 'utf-8', 'format' => 'LETTER', 'orientation' => 'P'));
$pdf->SetTitle($reportName);
$pdf->SetMargins(0, 0, 8);
// $pdf->SetProtection(array('print', 'copy'), "KMSI", "KMSIOWN");


extract((array) $result[0]);

// CERTIFICATES
$cert_ereg = ($cert_ereg) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$cert_peos = ($cert_peos) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$cert_pdos = ($cert_pdos) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$cert_owwa = ($cert_owwa) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$cert_nc2 = ($cert_nc2) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$cert_ofw_infosheet = ($cert_ofw_infosheet) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';

// SUPPORTING DOCUMENT
$sup_doc_id988a = ($sup_doc_id988a) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$sup_pt6 = ($sup_pt6) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$sup_coe = ($sup_coe) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$sup_hq = ($sup_hq) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$sup_polohk = ($sup_polohk) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$sup_infosheet = ($sup_infosheet) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$sup_privacy_policy = ($sup_privacy_policy) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$sup_affidavit = ($sup_affidavit) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$sup_mmr_vac = ($sup_mmr_vac) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';

// OEC DOCUMENT
$sup_doc_id988a = ($sup_doc_id988a) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$oec_covid_dec = ($oec_covid_dec) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$oec_insurance = ($oec_insurance) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$oec_pregnancy_test = ($oec_pregnancy_test) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$oec_swab_test = ($oec_swab_test) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';

// MEDICAL DOCUMENT
$med_first_cert = ($med_first_cert) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$med_second_cert = ($med_second_cert) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$med_third_cert = ($med_third_cert) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';
$med_fourth_cert = ($med_fourth_cert) ? '<b style="color:green">Filed</b>' : '<b style="color:red">Not Filed</b>';

// dd($passport);
$info  = "  <style>
					.content{
						padding-left:1cm;
						padding-right:1cm;
					}
					
					.underline{
						border-bottom:1px solid black;
					}

					h5,h3,h2{
						color:white;
					}

					.btn {
						display: inline-block;
						margin-bottom: 0;
						font-weight: normal;
						text-align: center;
						white-space: nowrap;
						vertical-align: middle;
						-ms-touch-action: manipulation;
						touch-action: manipulation;
						cursor: pointer;
						background-image: none;
						border: 1px solid transparent;
						padding: 6px 12px;
						font-size: 14px;
						line-height: 1.42857143;
						border-radius: 4px;
						-webkit-user-select: none;
						-moz-user-select: none;
						-ms-user-select: none;
						user-select: none;
					}
					.btn-primary {
						color: #ffffff;
						background-color: #337ab7;
						border-color: #2e6da4;
					}
				</style>";
$info .= "
		<body style='font-family:Book Antiqua;'>	
			<div>
				<table width='60%'  >
					<tr>
						<td rowspan='4' style='text-align: right;' width='50%'><img src='images/logo.png' style='width: 60px;text-align: center;' /></td>
						<td valign='middle' width='90%' style='padding: 0;text-align: center;' width='75%'><span style='font-size: 13px;'><b>KINGS MANPOWER SERVICES</b></span></td>
					</tr>
					<tr>
						<td valign='middle' style='padding: 0;text-align: center;'><span style='font-size: 13px;' width='75%'><strong>Envision and achieve an optimum goal
						</strong></span></td>
					</tr>
					<tr>
						<td valign='middle' style='padding: 0;text-align: center;'><span style='font-size: 13px;' width='75%'><strong>Infosheet</strong></span></td>
					</tr>
				</table>
			</div>";

if(in_array("GI", $edatalist)){
$info .= "
			<div class='content' style='margin-top:.4cm;'>
				<table  style='background-color: black;'>
					<tr>
						<td>
						<h2>GENERAL INFORMATION</h2>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Applicant ID:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $applicant_id . "</td>
									<td width='10%'></td>
									<td width='10%' style='font-size: 15px;color:black;'><b>Sales Manager:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $sales_manager . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>ER No:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $er_ref . "</td>
									<td width='10%'></td>
									<td width='10%' style='font-size: 15px;color:black;'><b>Maid No:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $maid_ref . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Jobsite:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $jobsite . "</td>
									<td width='10%'></td>
									<td width='10%' style='font-size: 15px;color:black;'><b>Branch:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $branch . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>First Name:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $fname . "</td>
									<td width='10%'></td>
									<td width='10%' style='font-size: 15px;color:black;'><b>Last Name:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $lname . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Middle Name:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $mname . "</td>
									<td width='10%'></td>
									<td width='10%' style='font-size: 15px;color:black;'><b>Contact:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $contact . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Address:</b></td>
									<td width='35%' style='font-size: 15px;' colspan='3'>" . $address . "</td>

								</tr>
							</table>
						</td>
					<td align='right'><img src='" . $user_profile_face . "' height='155px' width='140px' style='border: 1px solid #a1a1a1;margin-top:1px' /></td>
					</tr>
				</table>
			</div>";
}

if (in_array("AI", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Applicant Information</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='15%' style='font-size: 11px;color:black;'><b>Family Contact:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $family_contact_name . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Contact #:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $family_contact . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Gender:</b></td>
									<td width='18%' style='font-size: 11px;'>" . ucfirst($gender) . "</td>
								</tr>
								<tr>
									<td width='15%' style='font-size: 11px;color:black;'><b>First Time:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $is_first . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Ex Abroad?:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $is_ex_abroad . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Abroad Exp:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $abroad_experience . "</td>
								</tr>
								<tr>
									<td width='15%' style='font-size: 11px;color:black;'><b>Walk-in?:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $is_walkin . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Date Applied:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $date_applied . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Total Cost:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $total_cost . "</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
if (in_array("BS", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Bio Status</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Bio Transferred:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $bio_trans_date . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Bio Lunched:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $bio_lunch_date . "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Bio Status:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $bio_status . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Availability:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $bio_availability . "</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
if (in_array("PI", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Passport Information</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='20%' style='font-size: 15px;color:black;'><b>Passport #:</b></td>
									<td width='20%' style='font-size: 15px;'>" . $passport_no . "</td>
									<td width='10%'></td>
									<td width='20%' style='font-size: 15px;color:black;'><b>Coutry Issued:</b></td>
									<td width='20%' style='font-size: 15px;'>" . $passport_place_issued . "</td>
								</tr>
								<tr>
									<td width='20%' style='font-size: 15px;color:black;'><b>Date Issued:</b></td>
									<td width='20%' style='font-size: 15px;'>" . $passport_issued . "</td>
									<td width='10%'></td>
									<td width='20%' style='font-size: 15px;color:black;'><b>Expiration:</b></td>
									<td width='20%' style='font-size: 15px;'>" . $passport_validity . "</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
if (in_array("VR", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Vacinnation Record</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='100%' colspan='6' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>First Vacinnation</b></td>
								</tr>
								<tr>
									<td width='15%' style='font-size: 11px;color:black;'><b>Date:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $vac_first_dose_date . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Brand:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $vac_first_brand . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Country:</b></td>
									<td width='18%' style='font-size: 11px;'>" . Extras::getCountry($vac_first_country) . "</td>
								</tr>
								<tr>
									<td width='100%' colspan='6' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Second Vacinnation</b></td>
								</tr>
								<tr>
									<td width='15%' style='font-size: 11px;color:black;'><b>Date:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $vac_second_dose_date . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Brand:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $vac_second_brand . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Country:</b></td>
									<td width='18%' style='font-size: 11px;'>" . Extras::getCountry($vac_second_country) . "</td>
								</tr>
								<tr>
									<td width='100%' colspan='6' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Booster</b></td>
								</tr>
								<tr>
									<td width='15%' style='font-size: 11px;color:black;'><b>Date:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $vac_booster_dose_date . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Brand:</b></td>
									<td width='18%' style='font-size: 11px;'>" . $vac_booster_brand . "</td>
									<td width='15%' style='font-size: 11px;color:black;'><b>Country:</b></td>
									<td width='18%' style='font-size: 11px;'>" . Extras::getCountry($vac_booster_country) . "</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
if (in_array("MR", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Medical Record</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>First Medical</b></td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Clinic:</b></td>
									<td width='35%' style='font-size: 15px;'>" . Extras::getMedical($med_first_clinic) . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Taken:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $med_first_date . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Result:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $med_first_result . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Cost:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $med_first_cost . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Certificate:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $med_first_cert . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b></b></td>
									<td width='25%' style='font-size: 15px;'></td>
								</tr>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Second Medical</b></td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Clinic:</b></td>
									<td width='35%' style='font-size: 15px;'>" . Extras::getMedical($med_second_clinic) . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Taken:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $med_second_date . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Result:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $med_second_result . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Cost:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $med_second_cost . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Certificate:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $med_second_cert . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b></b></td>
									<td width='25%' style='font-size: 15px;'></td>
								</tr>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Third Medical</b></td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Clinic:</b></td>
									<td width='35%' style='font-size: 15px;'>" . Extras::getMedical($med_third_clinic) . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Taken:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $med_third_date . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Result:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $med_third_result . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Cost:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $med_third_cost . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Certificate:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $med_third_cert . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b></b></td>
									<td width='25%' style='font-size: 15px;'></td>
								</tr>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Fourth Medical</b></td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Clinic:</b></td>
									<td width='35%' style='font-size: 15px;'>" . Extras::getMedical($med_fourth_clinic) . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Taken:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $med_fourth_date . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Result:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $med_fourth_result . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Cost:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $med_fourth_cost . "</td>
								</tr>
								<tr>
									<td width='10%' style='font-size: 15px;color:black;'><b>Certificate:</b></td>
									<td width='35%' style='font-size: 15px;'>" . $med_fourth_cert . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b></b></td>
									<td width='25%' style='font-size: 15px;'></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>";
}

if (in_array("JO", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Job Order</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>JO Receive:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $jo_received . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>JO Confirmed:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $jo_confirmed . "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>ER Cancel?:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $jo_er_iscancel . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>MAID Cancel?:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $jo_maid_iscancel . "</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
if (in_array("VI", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>VISA Information</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='20%' style='font-size: 15px;color:black;'><b>VISA #:</b></td>
									<td width='20%' style='font-size: 15px;'>" . $visa_number . "</td>
									<td width='10%'></td>
									<td width='20%' style='font-size: 15px;color:black;'><b>Status:</b></td>
									<td width='20%' style='font-size: 15px;'>" . $visa_status . "</td>
								</tr>
								<tr>
									<td width='20%' style='font-size: 15px;color:black;'><b>Date Receive:</b></td>
									<td width='20%' style='font-size: 15px;'>" . $visa_date_received . "</td>
									<td width='10%'></td>
									<td width='20%' style='font-size: 15px;color:black;'><b>Expiration:</b></td>
									<td width='20%' style='font-size: 15px;'>" . $visa_date_expired . "</td>
								</tr>";
								if($visa_reactive_date != ""){
								$info .= "
								<tr>
									<td width='20%' style='font-size: 15px;color:black;'><b>Re-Active Date:</b></td>
									<td width='20%' style='font-size: 15px;'>". $visa_reactive_date."
									</td>
								</tr>";
								}
							$info .= "
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
if (in_array("CR", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Cetificates</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Pre-departure Orientation Seminar</b></td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>PDOS:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_pdos . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b></b></td>
									<td width='25%' style='font-size: 15px;'></td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Applied:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_pdos_date . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Release:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_pdos_release_date . "</td>
								</tr>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Overseas Workers Welfare Administration</b></td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>OWWA:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_owwa . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b></b></td>
									<td width='25%' style='font-size: 15px;'></td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Applied:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_owwa_date . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Release:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_owwa_release_date . "</td>
								</tr>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>National Certificate – Level II</b></td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>NCII:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_nc2 . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>By Applicant?</b></td>
									<td width='25%' style='font-size: 15px;'>".$cert_nc2_by_applicant. "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Payment:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_nc2_payment_status . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Cost:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_nc2_cost . "</td>
								</tr>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Other Certificate</b></td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>E-Registration:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_ereg . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>PEOS:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_peos . "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>OFW Infosheet:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $cert_ofw_infosheet . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Diploma:</b></td>
									<td width='25%' style='font-size: 15px;'>" . Extras::filledDiploma($applicant_id) . "</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
if (in_array("SD", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Supporting Document</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>EC/ID988A:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_doc_id988a . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>EC pt6 p4</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_pt6 . "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>COE:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_coe . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>HQ:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_hq . "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>MMR Vaccination:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_mmr_vac . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Infosheet:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_infosheet . "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Privacy Policy:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_privacy_policy . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Affidavit:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_affidavit . "</td>
								</tr>;";
								if($jobsite == "HK"){
									$info .= "<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>POLOHKSar:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $sup_polohk . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b></b></td>
									<td width='25%' style='font-size: 15px;'></td>
								</tr>";
								}
								$info .= "
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
if (in_array("OEC", $edatalist)) {
$info .= "	<div class='content' style='margin-top:.4cm;'>
				<table width='100%' style='background-color: black;'>
					<tr>
						<td>
						<h3>Overseas Employment Certificate</h3>
							<table width='100%' style='background-color: white;'>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>OEC #:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_number . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Receive:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_contract_received . "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Date Filed:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_date_filed . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Expiration:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_date_expiration . "</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Departure Date:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_flight_departure . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Pag-ibig:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_pagibig . "</td>
								</tr>
								<tr>
									<td width='100%' colspan='4' style='font-size: 15px;color:black;text-align:center;border: 1px solid black'><b>Documents</b></td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>COVID DEC:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_covid_dec . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Insurance</b></td>
									<td width='25%' style='font-size: 15px;'>". $oec_insurance."</td>
								</tr>
								<tr>
									<td width='25%' style='font-size: 15px;color:black;'><b>Preg Test:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_pregnancy_test . "</td>
									<td width='25%' style='font-size: 15px;color:black;'><b>Swab Test:</b></td>
									<td width='25%' style='font-size: 15px;'>" . $oec_swab_test . "</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>";
}
// echo $info; die;
$pdf->WriteHTML($info);

$pdf->Output($reportName . ' Infosheet.pdf', 'I');
