<section style="margin-top: 80px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span> Dashboard</a></li>
            <!-- <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li> -->
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-clipboard-list"></i> Total Reports</h3>
                    <p id="total-reports" class="card-text display-4"><?=$report_data['total']?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-exclamation-circle"></i> Active Obstructions</h3>
                    <p id="active-obstructions" class="card-text display-4"><?=$report_data['current']?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title"><i class="fas fa-check-circle"></i> Resolved Issues</h3>
                    <p id="resolved-issues" class="card-text display-4"><?=$report_data['completed']?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- <h3>Recent Reports</h3>
    <ul id="reports-list" class="list-group">
    </ul> -->
</section>
<!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Sample data
        const reports = [{
                id: 1,
                type: 'Pothole',
                status: 'Active'
            },
            {
                id: 2,
                type: 'Fallen Tree',
                status: 'Resolved'
            },
            {
                id: 3,
                type: 'Flooding',
                status: 'Active'
            }
        ];

        // Update statistics
        const totalReports = reports.length;
        const activeObstructions = reports.filter(report => report.status === 'Active').length;
        const resolvedIssues = reports.filter(report => report.status === 'Resolved').length;

        document.getElementById('total-reports').textContent = totalReports;
        document.getElementById('active-obstructions').textContent = activeObstructions;
        document.getElementById('resolved-issues').textContent = resolvedIssues;

        // Update recent reports
        const reportsList = document.getElementById('reports-list');
        reports.forEach(report => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = `${report.type} - ${report.status}`;
            reportsList.appendChild(listItem);
        });
    });
</script> -->