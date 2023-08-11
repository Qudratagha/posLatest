<div class="row d-flex justify-content-end mb-2">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h6>Previous Balance: {{$p_balance}}</h6>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h6>Current Balance: {{$c_balance}}</h6>
            </div>
        </div>
    </div>
   </div>
<table class="table table-hover" id="table">
    <thead>
        <th>#</th>
        <th>Date</th>
        <th>Description</th>
        <th class="text-end">Cradit +</th>
        <th class="text-end">Debit -</th>
        <th class="text-end">Balance</th>
    </thead>
    <tbody >
        @php
            $total_cr = 0;
            $total_db = 0;
            $balance = $p_balance;
        @endphp
        @foreach ($items as $item)
        @php
            $total_cr += $item->cr;
            $total_db += $item->db;
            $balance -= $item->db;
            $balance += $item->cr;

        @endphp
        <tr>
        <td>{{ $item->id }}</td>
        <td>{{ date("d M Y",strtotime($item->date)) }}</td>
        <td>{!! $item->desc !!}</td>
        <td class="text-end">{{ $item->cr == null ? '-' : round($item->cr,2)}}</td>
        <td class="text-end">{{ $item->db == null ? '-' : round($item->db,2)}}</td>
        <td class="text-end">{{ round($balance,2) }}</td>

        </tr>
    @endforeach

</tbody>
</table>
  <script src="{{ asset('assets/src/plugins/src/table/datatable/datatables.js') }}"></script>
<script>
     $('#table').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
                },

                "order": [[0, 'desc']],
                'columnDefs': [
                { 'sortable': false, 'searchable': false, 'visible': false, 'type': 'num', 'targets': [0] }
                ],
            });

            $("th").removeClass('sorting');
            $("th").removeClass('sorting_desc');
</script>
