<?php
include 'DAVID.php';

set_time_limit(0);
//create a service client using the wsdl
$client = new SoapClient('https://david.ncifcrf.gov/webservice/services/DAVIDWebService?wsdl');

//authenticate user email 
$au = new authenticate('yourRegisteredEmail@your.org');
$autRet = $client->authenticate($au);
if ($autRet->return == 'true'){
	//add a list
	$inputIds = '1112_g_at,1331_s_at,1355_g_at,1372_at,1391_s_at,1403_s_at,1419_g_at,1575_at,1645_at,1786_at,1855_at,1890_at,1901_s_at,1910_s_at,1937_at,1974_s_at,1983_at,2090_i_at,31506_s_at,31512_at,31525_s_at,31576_at,31621_s_at,31687_f_at,31715_at,31793_at,31987_at,32010_at,32073_at,32084_at,32148_at,32163_f_at,32250_at,32279_at,32407_f_at,32413_at,32418_at,32439_at,32469_at,32680_at,32717_at,33027_at,33077_at,33080_s_at,33246_at,33284_at,33293_at,33371_s_at,33516_at,33530_at,33684_at,33685_at,33922_at,33963_at,33979_at,34012_at,34233_i_at,34249_at,34436_at,34453_at,34467_g_at,34529_at,34539_at,34546_at,34577_at,34606_s_at,34618_at,34623_at,34629_at,34636_at,34703_f_at,34720_at,34902_at,34972_s_at,35038_at,35069_at,35090_g_at,35091_at,35121_at,35169_at,35213_at,35367_at,35373_at,35439_at,35566_f_at,35595_at,35648_at,35896_at,35903_at,35915_at,35956_s_at,35996_at,36234_at,36317_at,36328_at,36378_at,36421_at,36436_at,36479_at,36696_at,36703_at,36713_at,36766_at,37061_at,37096_at,37097_at,37105_at,37166_at,37172_at,37408_at,37454_at,37711_at,37814_g_at,37898_r_at,37905_r_at,37953_s_at,37954_at,37968_at,37983_at,38103_at,38128_at,38201_at,38229_at,38236_at,38482_at,38508_s_at,38604_at,38646_s_at,38674_at,38691_s_at,38816_at,38926_at,38945_at,38948_at,39094_at,39187_at,39198_s_at,39469_s_at,39511_at,39698_at,39908_at,40058_s_at,40089_at,40186_at,40271_at,40294_at,40317_at,40350_at,40553_at,40735_at,40790_at,40959_at,41113_at,41280_r_at,41489_at,41703_r_at,606_at,679_at,822_s_at,919_at,936_s_at,966_at';
	$idType = 'AFFYMETRIX_3PRIME_IVT_ID';
	$listName = 'make_up';
	$listType = 0;
	$al = new addList($inputIds, $idType, $listName, $listType);
	$addListResponse = $client->addList($al);
	
	//getChartReport
	$thd = 0.1;
	$ct = 2;
	$cr = new getChartReport($thd, $ct);
	$chartReport = $client->getChartReport($cr);
	
	//print table
	printTable($chartReport);
}else{
	exit($autRet->return); //authenticate failed
}

function printTable($res) {
	echo <<<EOT
	<table border="1">
  <tr>
    <td>Category</td>
    <td>Term</td>
    <td>Count</td>
    <td>%</td>
    <td>Pvalue</td>
    <td>Genes</td>
    <td>List Total</td>
    <td>Pop Hits</td>
    <td>Pop Total</td>
    <td>Fold Enrichment</td>
    <td>Bonferroni</td>
    <td>Benjamini</td>
    <td>FDR</td>
  </tr>
EOT;
	foreach ($res->return as $record) {
		echo "<tr>
		<td>{$record->categoryName}</td>
		<td>{$record->termName}</td>
		<td>{$record->listHits}</td>
		<td>{$record->percent}</td>
		<td>{$record->ease}</td>
		<td>{$record->geneIds}</td>
		<td>{$record->listTotals}</td>
		<td>{$record->popHits}</td>
		<td>{$record->popTotals}</td>
		<td>{$record->foldEnrichment}</td>
		<td>{$record->bonferroni}</td>
		<td>{$record->benjamini}</td>
		<td>{$record->afdr}</td>
		</tr>";
	}
	echo "</table>";
}
?>
