 @push('scripts')
            <script>
                $('#notification-clock').click(function (e) {
                    e.stopPropagation();
                    $(".menu").toggleClass('bar')
                });
                $('body').click(function (e) {
                    if ($('.menu').hasClass('bar')) {
                        $(".menu").toggleClass('bar')
                    }
                })
                id = {};

                function postRead(id) {
                    $.ajax({
                        type: 'post',
                        url: '{{url(' / notifications / markread ')}}',
                        data: {
                            id: id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                }
            </script>
@endpush