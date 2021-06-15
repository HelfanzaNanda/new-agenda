
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>


<script>
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
</script>

<script>
	function setLoading(e){
		e.target.innerText = "Loading..."
	}
	function hideLoading(e, text){
		e.target.innerText = text
	}
</script>


<script>
	function deleteData(url, redirect = null, datatable = false) {  
		$.confirm({
			title: 'Delete Data',
			content: 'apakah anda yakin menghapus data ini?',
			buttons: {
				delete: {
					text: 'Delete',
					btnClass: 'btn-danger',
					action: async function(){
						try {
							let response = await axios.delete(url)
							toastr["success"](response.data.message, "success")
							if(datatable){
								$('#datatable').DataTable().ajax.reload()
							}else{
								window.location.href = '/'+redirect
							}
							redirect
						} catch (error) {
							console.log(error);
						}
					}
				},
				batal: {
					text: 'Batal',
					btnClass: 'btn-success',
				}
			}
		});
	}
</script>