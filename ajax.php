<?php
function getFinancialData() {
	$lastUpdateTimestamp = file_get_contents('last_updated');
	$timestamp = time();
	if ($timestamp < intval($lastUpdateTimestamp) + 2 * 60) { // moins de 5 minutes depuis la dernier téléchargement
		// charger les données à partir du cache
		$data = file_get_contents('financial_data.cache');
	} else {
		// Récupération des données à partir du serveur Yahoo
		$data = file_get_contents(
		'http://finance.yahoo.com/webservice/v1/symbols/GOOG,AAPL,FB,AMZN,MSFT/quote?format=json'
		);
		// Mise à jour du cache
		file_put_contents('last_updated', time());
		file_put_contents('financial_data.cache', $data);
	}

	return $data;
}

print(getFinancialData());
?>