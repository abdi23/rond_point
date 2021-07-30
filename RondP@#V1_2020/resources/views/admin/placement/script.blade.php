<script>
    "use strict";

    $('select#ad_unit').select2({
        theme: 'bootstrap4',
        selectOnClose: true,
        allowClear: true,
        minimumResultsForSearch: -1,
        ajax: {
            url: "{{ route('advertisement.search') }}",
            processResults: function (data) {
                return {
                    results: data.map(function(item) {
                        if (item.size != '') {
                            return {
                                id: item.id,
                                text: item.name + ' (' + item.size + ')'
                            }
                        } else {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        }
                    })
                }
            }

        }
    })
</script>
