<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

<!-- alertifyjs js -->
<script src="{{ asset('assets/libs/alertifyjs/build/alertify.min.js') }}"></script>
<!-- notification init -->
<script src="{{ asset('assets/js/pages/notification.init.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Jquery Confirm -->
<script src="{{ asset('plugins/jquery-confirm/js/jquery-confirm.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Custom File input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('js/datatables-checkboxes.js') }}"></script>

{{-- Socket IO --}}
<script src="{{ asset('js/socket/socket.js') }}"></script>
<script>
    const socket = io('http://localhost:1010');

    $(document).ready(function(){
        $('.topcorner').hide();
        $('.loader').remove();
        $('#cctvTable').removeClass('d-none');
    })


    socket.on('notifAccessDoor', function(data) {
     $('.topcorner').hide();
        let countBefore = $('.countAccessDoor').text()
        $('.locationName').text(data.accessDoor.tDesc)
        let arrayPathImage = data.image.split("\\")
        let image = arrayPathImage[arrayPathImage.length-1]
        $('.imgAccess').attr('src', "http://localhost:1234/" + image)
        $('.countAccessDoor').text(parseInt(countBefore) + 1)
        // console.log(data.image);
        $('.topcorner').fadeIn('fast');

        setTimeout(() => {
            $('.topcorner').fadeOut('fast');
        }, 3000);
        createNotif(data.res.id, 'Access Door', data.accessDoor.tDesc, "<span class='badge bg-soft-warning text-warning'>Open Door</span>", changeDate(data.res.datetime))

    });

    socket.on('notifAccessDoors', function(data) {
        if (!data.status) {
            // console.log(data);
            let countBefore = $('.countAccessDoor').text()
            status = 'Offline'
            
            alertify.error(data.access_door.location_name + ' ( ' + status +' )')
            $('.countAccessDoor').text(parseInt(countBefore) + 1)
            createNotif(data.res.id, 'Access Door', data.access_door.location_name, "<span class='badge bg-soft-danger text-danger'>Offline</span>", changeDate(data.res.datetime))


        }
    });

    socket.on('notifNvr', function(data) {
        if (!data.status) {
            console.log(data);
            let countBefore = $('.countAccessDoor').text()
            let status = ''
            if (data.status == false) {
                status = 'Offline'
            }
            alertify.error(data.nvr.location_name + ' ( ' + status +' )')
            $('.countAccessDoor').text(parseInt(countBefore) + 1)
            createNotif(data.res.id, 'Nvr', data.nvr.location_name, "<span class='badge bg-soft-danger text-danger'>Offline</span>", changeDate(data.res.datetime))

        }
    });

    function openNew(url) {
      var url = url
      newwindow = window.open(url, '_blank');
      if (window.focus) {
        newwindow.focus()
      }
      return false;
    }

    function createNotif(id , type, name, status, datetime) {
        let notif = `
        <a href="{{ route('notification-log.index').'?id=' }} ${id}"class="text-reset notification-item">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/bel1.png') }}" class="rounded-circle avatar-sm" alt="user-pic">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${type} ${status}</h6>
                        <div class="font-size-13 text-muted">
                            <p class="mb-1">${name}</p>
                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>${datetime}</span></p>
                        </div>
                    </div>
                </div>
            </a>
        `;

        $('#notificationList .simplebar-content').prepend(notif)
    }

    function changeDate(date) {
        var date = new Date(date);
        var dateStr =
        date.getFullYear() + "-" +
        ("00" + (date.getMonth() + 1)).slice(-2) + "-" +
        ("00" + date.getDate()).slice(-2) + " " +
        ("00" + date.getHours()).slice(-2) + ":" +
        ("00" + date.getMinutes()).slice(-2) + ":" +
        ("00" + date.getSeconds()).slice(-2);
        return dateStr
    }

    $(function () {
        bsCustomFileInput.init();
        //Initialize Select2 Elements
        $('.select2').select2()

        // Datatables
        $("#userTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
        })

        $('#typeTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true
        });

        $('#materialsTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true
        });

        
        $('#DepartementTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true
        });
        
        $('#cctvTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true
        });
        
        $('#categoriesTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true
        });

        $('#bomTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true
        });

        $('#locationTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
        });

        $('#maintenanceTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
        });

        $('#table1').DataTable({
            "oLanguage": {
                "sInfo": "Showing page _PAGE_ of _PAGES_"
            },
            'bLengthChange': false,
            'searching': false,
        });

        $('#table2').DataTable({
            "oLanguage": {
                "sInfo": "Showing page _PAGE_ of _PAGES_"
            },
            'bLengthChange': false,
            'searching': false,
        });

        $('#table3').DataTable({
            "oLanguage": {
                "sInfo": "Showing page _PAGE_ of _PAGES_"
            },
            'bLengthChange': false,
            'searching': false,
        });       

        $('#table4').DataTable({
            "oLanguage": {
                "sInfo": "Showing page _PAGE_ of _PAGES_"
            },
            'bLengthChange': false,
            'searching': false,
        });       

        $('#tableImage').DataTable({
            'bLengthChange': false,
            'searching': false,
            "paging":   false,
            "ordering": false,
            "info":     false
        }); 

        $('#tableReferenceDocument').DataTable({
            'bLengthChange': false,
            'searching': false,
            "paging":   false,
            "ordering": false,
            "info":     false
        }); 

        $('#tableMaterial').DataTable({
            'bLengthChange': false,
            'searching': false,
            "paging":   false,
            "ordering": false,
            "info":     false
        }); 
        
        $('#taskTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true
        });

        $('#taskGroupTable').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true
        });
    })

   $("#checkbox").click(function () {
       if ($("#checkbox").is(':checked')) {
           $("#e1 > option").prop("selected", "selected");
           $("#e1").trigger("change");
       } else {
           $("#e1 > option").removeAttr("selected");
           $("#e1").val("");
           $("#e1").trigger("change");
       }
   });

   function detailModal(title, url, width) {
        $.confirm({
            title: title,
            theme : 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'URL:'+url,
            animation: 'zoom',
            closeAnimation: 'scale',
            animationSpeed: 400,
            closeIcon: true,
            columnClass: width,
            buttons: {
                close: {
                    btnClass: 'btn-dark font-bold',                    
                }
            },
        });
    }

    function modalDelete(title, name, url, link) {
        $.confirm({
            title: `Delete ${title}?`,
            content: `Are you sure want to delete ${name}`,
            autoClose: 'cancel|8000',
            buttons: {
                delete: {
                    text: 'delete',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_method": 'delete',
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                window.location.href = link
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    
                }
            }
        });        
    }

    function logout() {
        $.confirm({
            icon: 'fas fa-sign-out-alt',
            title: 'Logout',
            theme: 'supervan',
            content: 'Are you sure want to logout?',
            autoClose: 'cancel|8000',
            buttons: {
                logout: {
                    text: 'logout',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/logout',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                location.reload();
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    
                }
            }
        });
    }
</script>

@yield('script')