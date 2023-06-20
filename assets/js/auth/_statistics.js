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
        location_stat = res.data.location_stat;
        browser_stat = res.data.browser_stat;
        platform_stat = res.data.platform_stat;
        referrer_stat = res.data.referrer_stat;
        most_viewed_url = res.data.most_viewed_url;
        
        _siteVisitChart(site_visit);
        _linkCreatedChart(link_created_stat);
        _linkCountChart(link_click_stat);
        _locationChart(location_stat);
        _browserStatChart(browser_stat)
        _platformStatChart(platform_stat)
        _referrerStatChart(referrer_stat)
        _mostViewedUrl(most_viewed_url);
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
const _mostViewedUrl = (most_viewed_url) => {
    let views = [];
    let url_param = [];
    let string = "";

    stats = most_viewed_url;
    for(var i in stats){
        views.push(stats[i].views);
        url_param.push(stats[i].url_param);

        string +='<div class="col-2= col-lg-1 col-md-1 " style="margin-top:-2px;">'
                +'<label class="font-13" for="">'+stats[i].views+'</label>'
            +'</div>'
            +'<div class="col-10 col-lg-3 col-md-3 " style="margin-top:-2px;">'
            +'<label class="font-13" for=""><a target="_blank" rel="noopener" href="'+base_url+'stat/'+stats[i].url_param+'">'+stats[i].url_param+'</a></label>'
        +'</div>'
        +'<div class="col-12 col-lg-8 col-md-8  mb-2">'
            +'<div class="progress progress-lg">'
                +'<div class="progress-bar bg-success" role="progressbar" style="width: '+stats[i].percentage+'%" aria-valuenow="'+stats[i].url_param+'" aria-valuemin="0" aria-valuemax="100"></div>'
            +'</div>'
       +' </div>';
    }
    $("#_most_viewed_url_chart").html(string);
}
var browser_stat_chart;
const _browserStatChart = (data) => {
    let count = [];
    let browser = [];

    stats = data.browser_statistics;
    for(var i in stats){
        count.push(stats[i].count);
        browser.push(stats[i].browser);
    }

    if (browser_stat_chart) {
        browser_stat_chart.destroy();
    }  
    color = [];
    
    color = [
        'rgb(5, 138, 215)',
        'rgb(28, 215, 156)',
        'rgb(5, 203, 98)',
        'rgb(28, 125, 215)',
        'rgb(28, 125, 215)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 151)',
        'rgb(28, 215, 76)',
        'rgb(5, 215, 213)',
        'rgb(215, 28, 54)',
        'rgb(28, 208, 215)',
        'rgb(28, 182, 215)',
        'rgb(28, 125, 215)',
        'rgb(138, 28, 215)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 98)',
        'rgb(215, 59, 28)',
        'rgb(215, 129, 28)',
        'rgb(215, 178, 28)',
        'rgb(195, 215, 28)',
        'rgb(89, 215, 28)',
    ];

    for (var i=0;i<browser.length;i++) {
        color.push(browser[i].browser); 
    }
    const ctx = document.getElementById('_browser_overview');
    browser_stat_chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: browser,
            datasets: [{
                label: '',
                data: count,
                backgroundColor: color,
                borderColor: '#fff',
                hoverOffset: 4
            }],
        },
        options: {
            layout: {
                padding: 20
            },
           
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
    $("#loader").attr('hidden','hidden');
}
var platform_stat_chart;
const _platformStatChart = (data) => {
    let count = [];
    let platform = [];
    stats = data.platform_statistics;
    for(var i in stats){
        count.push(stats[i].count);
        platform.push(stats[i].platform);
    }
    if (platform_stat_chart) {
        platform_stat_chart.destroy();
    }  
    color = [];
    
    color = [
        'rgb(28, 215, 156)',
        'rgb(5, 203, 98)',
        'rgb(28, 125, 215)',
        'rgb(5, 215, 213)',
        'rgb(5, 138, 215)',
        'rgb(5, 203, 98)',
        'rgb(28, 215, 156)',
        'rgb(195, 215, 28)',
        'rgb(215, 28, 151)',
        'rgb(5, 138, 215)',
        'rgb(89, 215, 28)',
        'rgb(28, 215, 76)',
        'rgb(28, 215, 156)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(153, 102, 25)',
        'rgb(138, 28, 215)',
        'rgb(215, 28, 151)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 98)',
        'rgb(215, 28, 54)',
        'rgb(215, 59, 28)',
        'rgb(215, 129, 28)',
        'rgb(215, 178, 28)',
        'rgb(201, 203, 207)',
    ];

    for (var i=0;i<platform.length;i++) {
        color.push(platform[i].platform); 
    }
    const ctx = document.getElementById('_platform_overview');
    platform_stat_chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: platform,
            datasets: [{
                label: 'Platform',
                data: count,
                backgroundColor: color,
                borderColor: '#fff',
                borderWidth: 1,
                hoverOffset: 4
            }],
        },
        options: {
            layout: {
                padding: 20
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
}
var referrer_stat_chart;
const _referrerStatChart = (data) => {
    let count = [];
    let referrer = [];
    stats = data.referrer_statistics;
    for(var i in stats){
        count.push(stats[i].count);
        referrer.push(stats[i].referrer);
    }
    
    if (referrer_stat_chart) {
        referrer_stat_chart.destroy();
    }  
    color = [];
    color = [
        'rgb(5, 203, 98)',
        'rgb(28, 125, 215)',
        'rgb(5, 215, 213)',
        'rgb(5, 138, 215)',
        'rgb(5, 203, 98)',
        'rgb(28, 215, 156)',
        'rgb(75, 192, 192)',
        'rgb(215, 28, 151)',
        'rgb(89, 215, 28)',
        'rgb(28, 215, 76)',
        'rgb(28, 215, 156)',
        'rgb(54, 162, 235)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(153, 102, 25)',
        'rgb(138, 28, 215)',
        'rgb(215, 28, 151)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 98)',
        'rgb(215, 28, 54)',
        'rgb(215, 59, 28)',
        'rgb(215, 129, 28)',
        'rgb(215, 178, 28)',
        'rgb(201, 203, 207)',
    ];
    for (var i=0;i<referrer.length;i++) {
        color.push(referrer[i].referrer); 
    }
    const ctx = document.getElementById('_referrer_overview');
    referrer_stat_chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: referrer,
            datasets: [{
                label: 'Referrer',
                data: count,
                backgroundColor: color,
                borderColor: color,
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
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
                    position: 'bottom',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
}
const _locationChart = (data) => {
    let count = [];
    let country = [];
    let string = "";

    stats = data.country_statistics;
    for(var i in stats){
        count.push(stats[i].count);
        country.push(stats[i].country);

        string +='<div class="col-2 col-lg-1 col-md-1 " style="margin-top:-2px;">'
                +'<label class="font-13" for="">'+stats[i].count+'</label>'
            +'</div>'
            +'<div class="col-10 col-lg-3 col-md-3 " style="margin-top:-2px;">'
            +'<label class="font-13" for="">'+stats[i].country+'</label>'
        +'</div>'
        +'<div class="col-12 col-lg-8 col-md-8  mb-2">'
            +'<div class="progress progress-lg">'
                +'<div class="progress-bar bg-success" role="progressbar" style="width: '+stats[i].percentage+'%" aria-valuenow="'+stats[i].country+'" aria-valuemin="0" aria-valuemax="100"></div>'
            +'</div>'
       +' </div>';
    }
    $("#_location_chart").html(string);
}
if (_state == 'dashboard'){
    range = '15_days'
    _getWebsiteVisitsStatistics(range);
    _getWebsiteStatistics(range);
}
