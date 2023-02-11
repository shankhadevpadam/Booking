<script>
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 5000
	});
</script>

@if(session()->has('success'))
	<script>
	    Toast.fire({
	    	icon: 'success',
	        title: '{{ session()->get('success') }}'
	    })
	</script>
@endif

@if(session()->has('error'))
	<script>
	    Toast.fire({
	    	icon: 'error',
	        title: '{{ session()->get('error') }}'
	    })
	</script>
@endif

<script>
	$(document).ready(function () {
		$('#checkall').click(function (){
			if ($(this).is(':checked')){
				$('.delete_check').prop('checked', true);
			} else {
				$('.delete_check').prop('checked', false);
			}
		});
	});

	function confirmDelete(url, tableId, message = "Deleted item can't be recovered.") {
		Swal.fire({
			title: 'Are you sure?',
			text: message,
			icon: false,
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'GET',
					url: url,
					complete: function (response) {
						$('#'+tableId).DataTable().ajax.reload();
						Livewire.emit('dataFilter');
					}
				});
		  	}
		})
	}

	function confirmDeletePermanently(url, id, tableId) {
		let ids = [];
		ids.push(id);

		Swal.fire({
			title: 'Are you sure?',
			text: 'Deleted item can\'t be recovered.',
			icon: false,
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'POST',
					data: {ids: ids},
					url: url,
					complete: function (response) {
						$('#'+tableId).DataTable().ajax.reload(function () {
							$('#checkall').prop('checked', false);
							Livewire.emit('dataFilter');
						});
					}
				});
		  	}
		})
	}

	function restore(url, id, tableId) {
		let ids = [];
		ids.push(id);

		$.ajax({
			type: 'POST',
			data: {ids: ids},
			url: url,
			complete: function (response) {
				$('#'+tableId).DataTable().ajax.reload(function () {
					$('#checkall').prop('checked', false);
					Livewire.emit('dataFilter');
				});
			}
		});
	}

	function bulkDelete(dataTable) {
		let action = $('#bulk-action').val();

		let url = $('#bulk-action option:selected').data('url');

		let deleteids = [];

		$("input:checkbox[class=delete_check]:checked").each(function () {
			deleteids.push($(this).val());
		});

		if (action === 'delete' && deleteids.length > 0) {
			Swal.fire({
				title: 'Are you sure?',
				text: 'Deleted items can\'t be recovered.',
				icon: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'POST',
						data: {ids: deleteids},
						url: url,
						complete: function (response) {
							$(dataTable).DataTable().ajax.reload(function () {
								$('#checkall').prop('checked', false);
							});
						}
					});
				}
			})
		}

		if (action === 'completely') {
			Swal.fire({
				title: 'Are you sure?',
				text: 'Deleted items can\'t be recovered.',
				icon: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'GET',
						url: url,
						complete: function (response) {
							$(dataTable).DataTable().ajax.reload(function () {
								$('#checkall').prop('checked', false);
							});
						}
					});
				}
			})
		}

		if (action === 'trash' && deleteids.length > 0) {
			Swal.fire({
				title: '{{ __('Are you sure?') }}',
				text: '{{ __("Deleted items move into trash.") }}',
				icon: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'POST',
						data: {ids: deleteids},
						url: url,
						complete: function (response) {
							$(dataTable).DataTable().ajax.reload(function () {
								$('#checkall').prop('checked', false);
								Livewire.emit('dataFilter');
							});
						}
					});
				}
			})
		}

		if (action === 'restore' && deleteids.length > 0) {
			$.ajax({
				type: 'POST',
				data: {ids: deleteids},
				url: url,
				complete: function (response) {
					$(dataTable).DataTable().ajax.reload(function () {
						$('#checkall').prop('checked', false);
						Livewire.emit('dataFilter');
					});
				}
			});
		}

		if (action === 'permanently' && deleteids.length > 0) {
			Swal.fire({
				title: 'Are you sure?',
				text: 'Deleted items can\'t be recovered.',
				icon: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'POST',
						url: url,
						data: {ids: deleteids},
						complete: function (response) {
							$(dataTable).DataTable().ajax.reload(function () {
								$('#checkall').prop('checked', false);
								Livewire.emit('dataFilter');
							});
						}
					});
				}
			})
		}

		if (action === 'empty-trash') {
			Swal.fire({
				title: 'Are you sure?',
				text: 'Deleted items can\'t be recovered.',
				icon: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'GET',
						url: url,
						complete: function (response) {
							$(dataTable).DataTable().ajax.reload(function () {
								$('#checkall').prop('checked', false);
								Livewire.emit('dataFilter');
							});
						}
					});
				}
			})
		}
	}
</script>	
