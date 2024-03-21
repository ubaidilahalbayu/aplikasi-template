<hr>
<h3>Main Pokemon</h3>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pokemon</th>
            <th>Exp</th>
            <th>Height</th>
            <th>Weight</th>
        </tr>
    </thead>
</table>u
<script type="text/javascript">
    $(document).ready(function (){
        var table = new DataTable('#myTable', {
            // config options...
            columnDefs: [
                { width: '10%', targets: 0 },
                { className: "text-center", targets: '_all'}
            ]
        });
        renderTable();
        function renderTable() {
            $.ajax({
                url: "https://pokeapi.co/api/v2/pokemon?limit=100000&offset=0"
            }).done(function (result) {
                // console.log(result.results[0].name);
                var data = result.results;
                var rowTable = [];
                for (let i = 0; i < data.length; i++) {
                    $.ajax({
                        url: data[i].url
                    }).done(function (result2) {
                        // console.log(result2);
                        var columnTable = [];
                        columnTable.push(i+1);
                        columnTable.push(data[i].name);
                        columnTable.push(result2.base_experience);
                        columnTable.push(result2.height);
                        columnTable.push(result2.weight);
                        // console.log(columnTable);
                        rowTable.push(columnTable);
                        table.row.add(columnTable).draw(false);
                    });
                }
                // console.log(rowTable);
                // table.row.add(rowTable).draw(false);
            });
        }
    });
</script>