<?php
class cInsert
{
	function vInsertData($afields, $atable, $avalues)
	{
		$countarray_field = count($afields) - 1;
		$countarray_value = count($avalues) - 1;
		$fieldname = "";
		$datavalue = "";
		for ($i = 0; $i <= $countarray_field; $i++) {
			if ($i == $countarray_field) {
				$separator = "";
			} else {
				$separator = ",";
			}
			$fieldname = $fieldname . $afields[$i] . $separator;
			$datavalue = "" . $datavalue . $avalues[$i] . $separator;
		}
		$allstatement = "insert into " . $atable . "(" . $fieldname . ") values(" . $datavalue . ")";
		$query = $allstatement;
		$result = mysqli_query($GLOBALS["conn"], $query);

		echo "<br>";
		if ($result) {
			$last_id = mysqli_insert_id($GLOBALS["conn"]);
			echo "<script>
						Swal.fire({
						  position:'center',
						  width:'16em',
						  icon: 'success',	
						  text: 'Data berhasil disimpan',
						  type: 'success',
						}).then(function (result) {
						  if (true) {
						    window.location = '';
						  }
				}) </script>";
			return $last_id;	 
		} else {
			echo "<script>
						Swal.fire({
						  position:'center',
						  width:'16em',
						  icon: 'error',	
						  text: 'Data tidak berhasil disimpan',
						  type: 'error',
						}).then(function (result) {
						  if (true) {
						    window.location = '';
						  }
				}) </script>";
			return false; 
		}
	}

	function vInsertDataTrial($afields, $atable, $avalues)
	{
		$countarray_field = count($afields) - 1;
		$fieldname = "";
		$datavalue = "";
		for ($i = 0; $i <= $countarray_field; $i++) {
			if ($i == $countarray_field) {
				$separator = "";
			} else {
				$separator = ",";
			}
			$fieldname = $fieldname . $afields[$i] . $separator;
			$datavalue = "" . $datavalue . $avalues[$i] . $separator;
		}
		$allstatement = "insert into " . $atable . "(" . $fieldname . ") values(" . $datavalue . ")";
		$query = $allstatement;
		echo "<p>" . $query . "</p>";
	}

	public function getLastInsertId() {
        return mysqli_insert_id($GLOBALS["conn"]);
    }
}
