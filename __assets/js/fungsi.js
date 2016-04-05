
function loadUrl(urls){
	//$("#konten").empty();
    $("#konten").empty().addClass("loading");
   // $("#konten").html("").addClass("loading");
	$.get(urls,function (html){
	    $("#konten").html(html).removeClass("loading");
    });
}

function getClientHeight(){
	var theHeight;
	if (window.innerHeight)
		theHeight=window.innerHeight;
	else if (document.documentElement && document.documentElement.clientHeight) 
		theHeight=document.documentElement.clientHeight;
	else if (document.body) 
		theHeight=document.body.clientHeight;
	
	return theHeight;
}

var divcontainer;
function windowFormPanel(html,judul,width,height){
	divcontainer = $('#jendela');
	$(divcontainer).unbind();
	$('#isiJendela').html(html);
    $(divcontainer).window({
		title:judul,
		width:width,
		height:height,
		autoOpen:false,
		top: Math.round(frmHeight/2)-(height/2),
		left: Math.round(frmWidth/2)-(width/2),
		modal:true,
		maximizable:false,
		minimizable: false,
		collapsible: false,
		closable: true,
		resizable: false,
	    onBeforeClose:function(){	   
			$(divcontainer).window("close",true);
			//$(divcontainer).window("destroy",true);
			//$(divcontainer).window('refresh');
			return true;
	    }		
    });
    $(divcontainer).window('open');       
}
function windowFormClosePanel(){
    $(divcontainer).window('close');
	//$(divcontainer).window('refresh');
}

var container;
function windowForm(html,judul,width,height){
    container = "win"+Math.floor(Math.random()*9999);
    $("<div id="+container+"></div>").appendTo("body");
    container = "#"+container;
    $(container).html(html);
    $(container).css('padding','5px');
    $(container).window({
       title:judul,
       width:width,
       height:height,
       autoOpen:false,
       maximizable:false,
       minimizable: false,
	   collapsible: false,
       resizable: false,
       closable:true,
       modal:true,
	   onBeforeClose:function(){	   
			$(container).window("close",true);
			$(container).window("destroy",true);
			return true;
	   }
    });
    $(container).window('open');        
}
function closeWindow(){
    $(container).window('close');
    $(container).html("");
}


function getClientWidth(){
	var theWidth;
	if (window.innerWidth) 
		theWidth=window.innerWidth;
	else if (document.documentElement && document.documentElement.clientWidth) 
		theWidth=document.documentElement.clientWidth;
	else if (document.body) 
		theWidth=document.body.clientWidth;

	return theWidth;
}


function genGrid(modnya, divnya, lebarnya, tingginya){
	if(lebarnya == undefined){
		lebarnya = getClientWidth-250;
	}
	if(tingginya == undefined){
		tingginya = getClientHeight-300
	}

	var kolom ={};
	var frozen ={};
	var judulnya;
	var param={};
	var urlnya;
	var urlglobal="";
	var url_detil="";
	var post_detil={};
	var fitnya;
	var klik=false;
	var doble_klik=false;
	var pagesizeboy = 10;
	var singleSelek = true;
	var nowrap_nya = true;
	var footer=false;
	
	switch(modnya){
		case "produk":
			judulnya = "";
			urlnya = "produk";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			frozen[modnya] = [	
				{field:'nama_produk',title:'Nama Produk',width:300, halign:'center',align:'left'},
				{field:'kode_produk',title:'Kode Produk',width:130, halign:'center',align:'left'},
			]
			kolom[modnya] = [	
				{field:'nama_kategori',title:'Kategori',width:150, halign:'center',align:'left'},
				{field:'hpp',title:'Harga Modal (HPP)',width:200, halign:'center',align:'right'},
				{field:'create_by',title:'Dibuat Oleh',width:130, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:130, halign:'center',align:'center'},
			]
		break;
		case "supplier":
			judulnya = "";
			urlnya = "supplier";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			frozen[modnya] = [	
				{field:'nama_supplier',title:'Nama Supplier',width:300, halign:'center',align:'left'},
			]
			kolom[modnya] = [	
				{field:'no_telp',title:'No. Telp',width:150, halign:'center',align:'left'},
				{field:'email',title:'Email',width:150, halign:'center',align:'left'},
				{field:'contact_person',title:'Kontak',width:150, halign:'center',align:'left'},
				{field:'statu',title:'Status',width:150, halign:'center',align:'left'},
				{field:'create_by',title:'Dibuat Oleh',width:100, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:120, halign:'center',align:'center'},
			]
		break;
		case "pembelian":
			judulnya = "";
			urlnya = "tbl_pembelian";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			frozen[modnya] = [	
				{field:'judul_ind',title:'Nama Supplier',width:300, halign:'center',align:'left'},
			]
			kolom[modnya] = [	
				{field:'create_by',title:'PO. Number',width:200, halign:'center',align:'left'},
				{field:'create_by',title:'Tanggal',width:150, halign:'center',align:'center'},
				{field:'create_by',title:'Total Harga',width:150, halign:'center',align:'right'},
				{field:'create_by',title:'Dibuat Oleh',width:100, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:120, halign:'center',align:'center'},
			]
		break;
		case "transfer_stok":
			judulnya = "List Transfer Stok";
			urlnya = "tbl_transfer_stok";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			frozen[modnya] = [	
				{field:'judul_ind',title:'Gerai Asal',width:300, halign:'center',align:'left'},
				{field:'judul_ind',title:'Gerai Tujuan',width:300, halign:'center',align:'left'},
			]
			kolom[modnya] = [	
				{field:'create_by',title:'Tanggal Transfer',width:150, halign:'center',align:'center'},
				{field:'create_by',title:'Dibuat Oleh',width:100, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:120, halign:'center',align:'center'},
			]
		break;
		case "outlet":
			judulnya = "List Gerai/Outlet";
			urlnya = "tbl_gerai";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			frozen[modnya] = [	
				{field:'judul_ind',title:'Nama Gerai',width:300, halign:'center',align:'left'},
			]
			kolom[modnya] = [	
				{field:'create_by',title:'Kota',width:150, halign:'center',align:'left'},
				{field:'create_by',title:'Dibuat Oleh',width:100, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:120, halign:'center',align:'center'},
			]
		break;
		case "perangkat_kasir":
			judulnya = "";
			urlnya = "perangkat_kasir";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			frozen[modnya] = [	
				{field:'nama_perangkat',title:'Nama Perangkat',width:300, halign:'center',align:'left'},
			]
			kolom[modnya] = [	
				{field:'nama_outlet',title:'Gerai / Outlet',width:150, halign:'center',align:'left'},
				{field:'perangkat_id',title:'ID Perangkat',width:200, halign:'center',align:'center'},
				{field:'create_by',title:'Dibuat Oleh',width:100, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:120, halign:'center',align:'center'},
			]
		break;
		case "pelanggan":
			judulnya = "List Pelanggan";
			urlnya = "tbl_pelanggan";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			frozen[modnya] = [	
				{field:'judul_ind',title:'Nama Gerai',width:300, halign:'center',align:'left'},
			]
			kolom[modnya] = [	
				{field:'create_by',title:'Nama Pelanggan',width:200, halign:'center',align:'left'},
				{field:'create_by',title:'ID Pelanggan',width:200, halign:'center',align:'left'},
				{field:'create_by',title:'Dibuat Oleh',width:100, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:100, halign:'center',align:'center'},
			]
		break;
		case "kategori_produk":
			judulnya = "";
			urlnya = "kategori_produk";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			kolom[modnya] = [	
				{field:'nama_kategori',title:'Nama Kategori',width:200, halign:'center',align:'left'},
				{field:'create_by',title:'Dibuat Oleh',width:100, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:100, halign:'center',align:'center'},
			]
		break;
		case "promo":
			judulnya = "";
			urlnya = "tbl_promo";
			fitnya = true;
			urlglobal = host+'backend/getdata/'+urlnya;
			frozen[modnya] = [	
				{field:'judul_ind',title:'Nama Promo',width:300, halign:'center',align:'left'},
			]
			kolom[modnya] = [	
				{field:'create_by',title:'Tanggal Mulai',width:200, halign:'center',align:'left'},
				{field:'create_by',title:'Tanggal Berakhir',width:200, halign:'center',align:'left'},
				{field:'create_by',title:'Dibuat Oleh',width:100, halign:'center',align:'left'},
				{field:'create_date',title:'Dibuat Tgl',width:100, halign:'center',align:'center'},
			]
		break;
		
	}
	
	grid_nya=$("#"+divnya).datagrid({
		title:judulnya,
        height:tingginya,
        width:lebarnya,
		rownumbers:true,
		iconCls:'database',
        fit:fitnya,
        striped:true,
        pagination:true,
        remoteSort: false,
		showFooter:footer,
		singleSelect:singleSelek,
        url: urlglobal,		
		nowrap: nowrap_nya,
		pageSize:pagesizeboy,
		pageList:[10,20,30,40,50,75,100,200],
		queryParams:param,
		frozenColumns:[
            frozen[modnya]
        ],
		columns:[
            kolom[modnya]
        ],
		onLoadSuccess:function(d){
			//gridVRList.datagrid('selectRow', 0);
			$('.yes').linkbutton({  
					iconCls: 'icon-cancel'  
			});
			$('.no').linkbutton({  
					iconCls: 'icon-ok'  
			});
			
		},
		onClickRow:function(rowIndex,rowData){
		 
        },
		onDblClickRow:function(rowIndex,rowData){
			
		},
		toolbar: '#tb_'+modnya,
		rowStyler: function(index,row){
			if(modnya == 'reservasi'){
				if (row.flag == 1){
					return 'background-color:#C5FFC2;'; // return inline style
				}else if(row.flag == 0){
					return 'background-color:#FFD1BB;'; // return inline style
				}
			}
			
		}
	});
}


function genform(type, modulnya, submodulnya, stswindow, tabel){
	var urlpost = host+'backend/get_form/'+submodulnya+'/form';
	var urldelete = host+'backend/simpan_data/'+tabel;
	var id_tambahan = "";
	
	switch(submodulnya){
		case "produk":
			table="tbl_produk";
			urlpost = host+'backend/getdisplay/get-form/'+submodulnya;
		break;
		
		case "supplier":
			table="tbl_supplier";
			urlpost = host+'backend/getdisplay/get-form/'+submodulnya;
		break;
		case "outlet":
			table="tbl_outlet";
			urlpost = host+'backend/getdisplay/get-form/'+submodulnya;
		break;
		case "perangkat_kasir":
			table="tbl_perangkat_kasir";
			urlpost = host+'backend/getdisplay/get-form/'+submodulnya;
		break;
		case "kategori_produk":
			table="cl_kategori_produk";
			urlpost = host+'backend/getdisplay/get-form/'+submodulnya;
		break;
		
		case "promo":
			table="tbl_promo";
			urlpost = host+'backend/getdisplay/get-form/'+submodulnya;
		break;
	}
	
	switch(type){
		case "add":
			if(stswindow == undefined){
				$('#grid_nya_'+submodulnya).hide();
				$('#detil_nya_'+submodulnya).empty().show().addClass("loading");
			}
			$.post(urlpost, {'editstatus':'add', 'id_tambahan':id_tambahan }, function(resp){
				if(stswindow == 'windowform'){
					windowForm(resp, judulwindow, lebar, tinggi);
				}else if(stswindow == 'windowpanel'){
					windowFormPanel(resp, judulwindow, lebar, tinggi);
				}else{
					$('#detil_nya_'+submodulnya).show();
					$('#detil_nya_'+submodulnya).html(resp).removeClass("loading");
				}
			});
		break;
		case "edit":
		case "delete":
		
			var row = $("#grid_"+submodulnya).datagrid('getSelected');
			if(row){
				if(type=='edit'){
					if(stswindow == undefined){
						$('#grid_nya_'+submodulnya).hide();
						$('#detil_nya_'+submodulnya).show().addClass("loading");	
					}
					$.post(urlpost, { 'editstatus':'edit', id:row.id, 'ts':table, 'submodul':submodulnya, 'bulan':row.bulan, 'tahun':row.tahun, 'id_tambahan':id_tambahan }, function(resp){
						if(stswindow == 'windowform'){
							windowForm(resp, judulwindow, lebar, tinggi);
						}else if(stswindow == 'windowpanel'){
							windowFormPanel(resp, judulwindow, lebar, tinggi);
						}else{
							$('#detil_nya_'+submodulnya).show();
							$('#detil_nya_'+submodulnya).html(resp).removeClass("loading");
						}
					});
				}else if(type=='delete'){
					if(confirm("Do You Want To Delete This Data ?")){
						loadingna();
						$.post(urldelete, {id:row.id, 'sts_crud':'delete'}, function(r){
							if(r==1){
								winLoadingClose();
								$.messager.alert('Roger Salon',"Row Data Was Deleted",'info');
								$('#grid_'+submodulnya).datagrid('reload');								
							}
							else{
								winLoadingClose();
								console.log(r)
								$.messager.alert('Roger Salon',"Failed",'error');
							}
						});	
					}
				}
				
			}
			else{
				$.messager.alert('Roger Salon',"Select Row In Grid",'error');
			}
		break;
		
	}
}

function kumpulAction(type, p1, p2, p3, p4, p5){
	switch(type){
		case "reservation":
			grid = $('#grid_reservasi').datagrid('getSelected');
			$.post(host+'backend/simpan_data/tbl_reservasi_confirm', { 'id':grid.id, 'confirm':p1 }, function(rsp){
				if(rsp == 1){
					$.messager.alert('Roger Salon',"Confirm OK",'info');
				}else{
					$.messager.alert('Roger Salon',"Failed Confirm",'error');
				}
				$('#grid_reservasi').datagrid('reload');	
			} );
		break;
		case "banner":
			grid = $('#grid_banner').datagrid('getSelected');
			$.post(host+'backend/simpan_data/tbl_banner_confirm', { 'id':grid.id, 'confirm':p1 }, function(rsp){
				if(rsp == 1){
					$.messager.alert('Roger Salon',"OK",'info');
				}else{
					$.messager.alert('Roger Salon',"Gagal",'error');
				}
				$('#grid_banner').datagrid('reload');	
			} );
		break;
		case "hapus_produk":
			$('#detail_fotonya').empty().addClass("loading");
			$.post(host+'backend/hapusfoto_detail/produk', { 'id':p1, 'nama_file':p2, 'id_header':p3  }, function(rsp){
				$('#detail_fotonya').html(rsp).removeClass("loading");
			} );
		break;
		case "hapus_service":
			$('#detail_fotonya').empty().addClass("loading");
			$.post(host+'backend/hapusfoto_detail/service', { 'id':p1, 'nama_file':p2, 'id_header':p3  }, function(rsp){
				$('#detail_fotonya').html(rsp).removeClass("loading");
			} );
		break;
	}
}	

function submit_form(frm,func){
	var url = jQuery('#'+frm).attr("url");
    jQuery('#'+frm).form('submit',{
            url:url,
            onSubmit: function(){
                  return $(this).form('validate');
            },
            success:function(data){
				//$.unblockUI();
                if (func == undefined ){
                     if (data == "1"){
                        pesan('Data Sudah Disimpan ','Sukses');
                    }else{
                         pesan(data,'Result');
                    }
                }else{
                    func(data);
                }
            },
            error:function(data){
				//$.unblockUI();
                 if (func == undefined ){
                     pesan(data,'Error');
                }else{
                    func(data);
                }
            }
    });
}

function fillCombo(url, SelID, value, value2, value3, value4){
	//if(Ext.get(SelID).innerHTML == "") return false;
	if (value == undefined) value = "";
	if (value2 == undefined) value2 = "";
	if (value3 == undefined) value3 = "";
	if (value4 == undefined) value4 = "";
	
	$('#'+SelID).empty();
	$.post(url, {"v": value, "v2": value2, "v3": value3, "v4": value4},function(data){
		$('#'+SelID).append(data);
	});

}
function formatDate(date) {
	var bulan=date.getMonth() +1;
	var tgl=date.getDate();
	if(bulan < 10){
		bulan='0'+bulan;
	}
	
	if(tgl < 10){
		tgl='0'+tgl;
	}
	return date.getFullYear() + "-" + bulan + "-" + tgl;
}


function clear_form(id){
	$('#'+id).find("input[type=text], textarea,select").val("");
	//$('.angka').numberbox('setValue',0);
}

var divcontainerz;
function windowLoading(html,judul,width,height){
    divcontainerz = "win"+Math.floor(Math.random()*9999);
    $("<div id="+divcontainerz+"></div>").appendTo("body");
    divcontainerz = "#"+divcontainerz;
    $(divcontainerz).html(html);
    $(divcontainerz).css('padding','5px');
    $(divcontainerz).window({
       title:judul,
       width:width,
       height:height,
       autoOpen:false,
       modal:true,
       maximizable:false,
       resizable:false,
       minimizable:false,
       closable:false,
       collapsible:false,  
    });
    $(divcontainerz).window('open');        
}
function winLoadingClose(){
    $(divcontainerz).window('close');
    //$(divcontainer).html('');
}
function loadingna(){
	windowLoading("<img src='"+host+"__assets/images/loading.gif' style='position: fixed;top: 50%;left: 50%;margin-top: -10px;margin-left: -25px;'/>","Please Wait",200,100);
}

function NumberFormat(value) {
	
    var jml= new String(value);
    if(jml=="null" || jml=="NaN") jml ="0";
    jml1 = jml.split("."); 
    jml2 = jml1[0];
    amount = jml2.split("").reverse();

    var output = "";
    for ( var i = 0; i <= amount.length-1; i++ ){
        output = amount[i] + output;
        if ((i+1) % 3 == 0 && (amount.length-1) !== i)output = '.' + output;
    }
    //if(jml1[1]===undefined) jml1[1] ="00";
   // if(isNaN(output))  output = "0";
    return output; // + "." + jml1[1];
}

function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	}


