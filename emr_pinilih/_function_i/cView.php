<?php
class cView
{
	function vViewData($sSql)
	{
		if (!isset($GLOBALS["conn"]) || !$GLOBALS["conn"]) {
			die("Koneksi ke database tidak ditemukan.");
		}
		$data = array();
		// echo "DEBUG QUERY: " . $sSql; // Tambahkan ini untuk melihat query yang dieksekusi
		$query = mysqli_query($GLOBALS["conn"], $sSql);
		while ($row = mysqli_fetch_assoc($query))
			$data[] = $row;
		return $data;
		mysqli_close($conn);
	}

	function vViewDataTrial($sSql)
	{
		echo "<p>";
		echo $sSql;
		echo "</p>";
	}
}
