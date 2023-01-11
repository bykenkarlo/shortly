function _getWebsiteVisitsStatistics(range){
    let params = new URLSearchParams({'range':range});
    fetch(base_url+'api/v1/statistics/_website_stat_chart?' + params, {
        method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        site_visit = res.data.site_visit;
        link_created_stat = res.data.link_created_stat;
        link_click_stat = res.data.link_click_stat;
        
        _siteVisitChart(site_visit);
        _linkCreatedChart(link_created_stat);
        _linkCountChart(link_click_stat);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

var visit_stat_chart;
function _siteVisitChart(site_visit) {
    let click_date = [];
    let click_count = [];
    if (visit_stat_chart) {
        visit_stat_chart.destroy();
    }
    for(var i in site_visit){
        click_date.push(site_visit[i].date);
        click_count.push(site_visit[i].views);
    }
    const ctx = document.getElementById('_website_visits');
    visit_stat_chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: click_date,
            datasets: [
                {
                    label: 'Site Visit',
                    data: click_count,
                    fill: true,
                    backgroundColor: 'rgba(5, 203, 98, .09)',
                    borderColor: 'rgba(5, 203, 98, 1)',
                    borderJoinStyle: 'round',
                    borderWidth: 1.5,
                    tension: .3
                }
            ]
        },
        options: {
           
            scales: {
                x: {
                    grid: {
                      display: false,
                    }
                },
                y: {
                    grid: {
                      display: false
                    }
                },
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
}
var link_created_chart;
function _linkCreatedChart(link_created_stat) {
    let link_created_date = [];
    let link_created_count = [];
    if (link_created_chart) {
        link_created_chart.destroy();
    }
    for(var i in link_created_stat){
        link_created_date.push(link_created_stat[i].date);
        link_created_count.push(link_created_stat[i].count);
    }
    const cty = document.getElementById('_link_created');
    link_created_chart = new Chart(cty, {
        type: 'line',
        data: {
            labels: link_created_date,
            datasets: [
                {
                    label: 'Link Created',
                    data: link_created_count,
                    fill: true,
                    backgroundColor: 'rgba(255, 188, 0, .09)',
                    borderColor: 'rgba(255, 188, 0,1)',
                    borderJoinStyle: 'round',
                    borderWidth: 1.5,
                    tension: .3
                }
            ]
        },
        options: {
           
            scales: {
                x: {
                    grid: {
                      display: false,
                    }
                },
                y: {
                    grid: {
                      display: false
                    }
                },
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
}
var link_click_chart;
function _linkCountChart(link_click_stat) {
    let link_click_date = [];
    let link_click_count = [];

    if (link_click_chart) {
        link_click_chart.destroy();
    }
    for(var i in link_click_stat){
        link_click_date.push(link_click_stat[i].date);
        link_click_count.push(link_click_stat[i].count);
    }
    const ctz = document.getElementById('_link_clicks_chart');
    link_click_chart = new Chart(ctz, {
        type: 'line',
        data: {
            labels: link_click_date,
            datasets: [
                {
                    label: 'Link Clicks',
                    data: link_click_count,
                    fill: true,
                    backgroundColor: 'rgba(54, 153, 255, .09)',
                    borderColor: 'rgba(54, 153, 255, 1)',
                    borderJoinStyle: 'round',
                    borderWidth: 1.5,
                    tension: .3
                }
            ]
        },
        options: {
            scales: {
                x: {
                    grid: {
                      display: false,
                    }
                },
                y: {
                    grid: {
                      display: false
                    }
                },
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: 'circle'
                    }
                }
            },
        }
    });
}
const _getWebsiteStatistics = (range) => {
    fetch(base_url+'api/v1/statistics/_website_stats', {
        method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        $("#_visits_today").text(res.data.visits_today);
        $("#_links_created").text(res.data.link_created)
        $("#_link_clicks").text(res.data.link_click)

    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
if (_state == 'dashboard'){
    range = '15_days'
    _getWebsiteVisitsStatistics(range);
    _getWebsiteStatistics(range);
}
