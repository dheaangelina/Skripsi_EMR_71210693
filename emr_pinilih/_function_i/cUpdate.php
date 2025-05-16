<?php
class cUpdate
{
	// penerimaan
	function vUpdateData($afields, $atable, $avalues, $datakey, $linkurl)
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
			$fieldname = $fieldname . $afields[$i] . '=' . $avalues[$i] . $separator;
		}
		$allstatement = "UPDATE " . $atable . " SET " . $fieldname . " WHERE " . $datakey . "";
		$query = $allstatement;
		//echo "<br>".$query."<br>";
		$result = mysqli_query($GLOBALS["conn"], $query);
		if ($result) {
			echo "<script>
						Swal.fire({
						  position:'center',
						  width:'16em',
						  icon: 'success',	
						  text: 'Data berhasil diubah',
						  type: 'success',
						}).then(function (result) {
						  if (true) {
						    window.location = '';
						  }
				}) </script>";
		} else {
			echo "<script>
						Swal.fire({
						  position:'center',
						  width:'16em',
						  icon: 'error',	
						  text: 'Data tidak berhasil diubah',
						  type: 'error',
						}).then(function (result) {
						  if (true) {
						    window.location = '';
						  }
				}) </script>";
		}
	}

	function vUpdateDataTrial($afields, $atable, $avalues, $datakey, $linkurl)
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
			$fieldname = $fieldname . $afields[$i] . '=' . $avalues[$i] . $separator;
		}
		$allstatement = "UPDATE " . $atable . " SET " . $fieldname . " WHERE " . $datakey . "";
		$query = $allstatement;
		echo "<p>" . $query . "</p>";
	}
}
