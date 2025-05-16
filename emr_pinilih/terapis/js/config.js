$(document).ready(function(){  
  $("#jenisDisabilitas").change(function(){ // Ketika user mengganti atau memilih data jenisDisabilitas
      $.ajax({
          type: "POST",
          url: "../admin/optionDisabilitas.php", // Isi dengan url/path file php yang dituju
          data: {jenisDisabilitas : $("#jenisDisabilitas").val()}, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
              }
          },
      success: function(response){ 
        $("#subDisabilitas").html(response.data_disabilitas).show();
      },
      error: function (xhr, ajaxOptions, thrownError) { 
        alert(thrownError); 
      }
    });
  });

  $(document).on("change", ".jd", function(){ 
    var idJenis = $(this).val(); // Ambil ID Jenis Disabilitas yang dipilih
    var idPasien = $(this).data("id"); // Ambil ID Pasien untuk ID unik dropdown
    
    $.ajax({
      type: "POST",
      url: "../admin/optionDisabilitas2.php",
      data: { idJenis: idJenis },
      dataType: "json",
      beforeSend: function(e) {
        if(e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $(".sd[data-id='" + idPasien + "']").html(response.data_disabilitas).show();
      },
      error: function(xhr, status, error) {
        console.error("Error:", error);
        }
    });
  });

  $("#provinsi").change(function(){ // Ketika user mengganti atau memilih data provinsi
      $.ajax({
          type: "POST", 
          url: "../admin/optionKotaKab.php", // Isi dengan url/path file php yang dituju
          data: {provinsi : $("#provinsi").val()}, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
              }
          },
      success: function(response){  
        $("#kotaKab").html(response.data_kotaKab).show();
      },
      error: function (xhr, ajaxOptions, thrownError) { 
        alert(thrownError); 
      }
    });
  });

  $(document).on("change", ".prov", function(){ 
    var idProv = $(this).val(); // Ambil ID Provinsi yang dipilih
    var idPasien = $(this).data("id"); // Ambil ID Pasien untuk ID unik dropdown

      $.ajax({
          type: "POST", 
          url: "../admin/optionKotaKab2.php", // Isi dengan url/path file php yang dituju
          data: {idProv : idProv }, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
              }
          },
      success: function(response){ 
        $(".kotaKab[data-id='" + idPasien + "']").html(response.data_kotaKab).show();
      },
      error: function (xhr, ajaxOptions, thrownError) { 
        alert(thrownError);
      }
    });
  });

  $("#kotaKab").change(function(){ // Ketika user mengganti atau memilih data kota kab
      $.ajax({
          type: "POST", 
          url: "../admin/optionKecamatan.php", // Isi dengan url/path file php yang dituju
          data: { kotaKab : $("#kotaKab").val()}, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
              }
          },
      success: function(response){ 
        $("#kecamatan").html(response.data_kecamatan).show();
      },
      error: function (xhr, ajaxOptions, thrownError) { 
        alert(thrownError);
      }
    });
  });

  $(document).on("change", ".kotaKab", function(){ 
    var idKotaKab = $(this).val(); // Ambil ID Provinsi yang dipilih
    var idPasien = $(this).data("id"); // Ambil ID Pasien untuk ID unik dropdown

      $.ajax({
          type: "POST", 
          url: "../admin/optionKecamatan2.php", // Isi dengan url/path file php yang dituju
          data: { idKotaKab : idKotaKab}, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
              }
          },
      success: function(response){  
        $(".kec[data-id='" + idPasien + "']").html(response.data_kecamatan).show();
      },
      error: function (xhr, ajaxOptions, thrownError) { 
        alert(thrownError);
      }
    });
  });

  $("#kecamatan").change(function(){ // Ketika user mengganti atau memilih data kecamatan
      $.ajax({
          type: "POST",
          url: "../admin/optionKelurahan.php", // Isi dengan url/path file php yang dituju
          data: { kecamatan : $("#kecamatan").val()}, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
              }
          },
      success: function(response){ 
        $("#kelurahan").html(response.data_kelurahan).show();
      },
      error: function (xhr, ajaxOptions, thrownError) { 
        alert(thrownError);
      }
    });
  });

  $(document).on("change", ".kec", function(){ 
    var idKec = $(this).val(); // Ambil ID Provinsi yang dipilih
    var idPasien = $(this).data("id"); // Ambil ID Pasien untuk ID unik dropdown

      $.ajax({
          type: "POST",
          url: "../admin/optionKelurahan2.php", // Isi dengan url/path file php yang dituju
          data: { idKec : idKec }, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
              }
          },
      success: function(response){ 
        $(".kel[data-id='" + idPasien + "']").html(response.data_kelurahan).show();
      },
      error: function (xhr, ajaxOptions, thrownError) { 
        alert(thrownError);
      }
    });
  });
});