import { Chart, ChartConfiguration } from 'chart.js/auto';
import { ViolinController, ViolinChart, Violin } from '@sgratzl/chartjs-chart-boxplot';

// Register the ViolinController with Chart.js
Chart.register(ViolinController, ViolinChart, Violin);

async function fetchChartData(url = '', color_by = 'celltypes') {
    console.log('getting chart data');
    // Default options are marked with *
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ color_by }) // Include the color_by variable in the request body
    });
    return response.json(); // parses JSON response into native JavaScript objects
}
function singleChart(data) {
    const chartsContainer = document.getElementById('chartsContainer');
    chartsContainer.innerHTML = '';
    const canvas = document.createElement('canvas');
    canvas.id = `scatterPlot`;
    chartsContainer.appendChild(canvas);

    const ctx = canvas.getContext('2d');

    const specialCategories = ['celltypes', 'level', 'sample_id', 'seurat_clusters'];

    if (!specialCategories.includes(window.sessionConfig.color_by)) {
        // Original function logic
        const scatterData = {
            datasets: [{
                label: `${window.sessionConfig.color_by}`,
                data: data.map(item => ({ x: item.Dim1, y: item.Dim2 })),
                backgroundColor: data.map(item => item.color)
            }]
        };

        const scatterChart = new Chart(ctx, {
            type: 'scatter',
            data: scatterData,
            options: {
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                weight: 'bold',
                                size: 14
                            },
                            color: 'white'
                        }
                    }
                }
            }
        });
    } else {
        // New function logic
        const uniqueCategories = [...new Set(data.map(item => item.category))];
        const categoryColors = uniqueCategories.reduce((acc, category, index) => {
            acc[category] = data.find(item => item.category === category).color;
            return acc;
        }, {});

        const scatterData = {
            datasets: uniqueCategories.map(category => ({
                label: category,
                data: data.filter(item => item.category === category).map(item => ({ x: item.Dim1, y: item.Dim2 })),
                backgroundColor: categoryColors[category]
            }))
        };

        const scatterChart = new Chart(ctx, {
            type: 'scatter',
            data: scatterData,
            options: {
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                weight: 'bold',
                                size: 14
                            },
                            color: 'white'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label;
                            }
                        }
                    }
                }
            }
        });
    }
}
// function singleChart(data) {
//
//     const chartsContainer = document.getElementById('chartsContainer');
//     chartsContainer.innerHTML = '';
//     // const canvasContainer = document.createElement('div');
//     const canvas = document.createElement('canvas');
//     canvas.id = `scatterPlot`;
//     // canvas.height = 500;
//     // canvas.width = 900;
//     chartsContainer.appendChild(canvas);
//
//     const ctx = canvas.getContext('2d');
//     const scatterData = {
//         datasets: [{
//             label: `${window.sessionConfig.color_by}`,
//             data: data.map(item => ({ x: item.Dim1, y: item.Dim2 })),
//             backgroundColor: data.map(item => item.color)
//         }]
//     };
//
//     const scatterChart = new Chart(ctx, {
//         type: 'scatter',
//         data: scatterData,
//         options: {
//             scales: {
//                 x: {
//                     type: 'linear',
//                     position: 'bottom'
//                 }
//             },
//             plugins: {
//                 legend: {
//                     labels: {
//                         font: {
//                             weight: 'bold',
//                             size: 14
//                         },
//                         color: 'white'
//                     }
//                 }
//             }
//         },
//     });
// }

function splitChart(data) {
    const groupedData = data.reduce((acc, item) => {
        if (!acc[item.category]) {
            acc[item.category] = [];
        }
        acc[item.category].push(item);
        return acc;
    }, {});

    const chartsContainer = document.getElementById('chartsContainer');
    chartsContainer.innerHTML = '';

    Object.keys(groupedData).forEach(category => {
        // Create a canvas element for each category
        const canvasContainer = document.createElement('div');
        const canvas = document.createElement('canvas');
        canvas.id = `scatterPlot-${category}`;
        canvas.height = 200;
        canvas.width = 400;
        // canvas.classList.add('h-[300px]', 'w-[300px]'); // Tailwind CSS classes for responsive design
        canvasContainer.appendChild(canvas);
        chartsContainer.appendChild(canvasContainer);


        const ctx = canvas.getContext('2d');
        const scatterData = {
            datasets: [{
                label: `${category}`,
                data: groupedData[category].map(item => ({ x: item.Dim1, y: item.Dim2 })),
                backgroundColor: groupedData[category].map(item => item.color)
            }]
        };

        new Chart(ctx, {
            type: 'scatter',
            data: scatterData,
            options: {
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        color: 'white'
                    }
                }
            }
        });
    });
}

function violinChart(data) {
    const chartsContainer = document.getElementById('chartsContainer');
    chartsContainer.innerHTML = '';
    const canvas = document.createElement('canvas');
    canvas.id = 'violin';
    chartsContainer.appendChild(canvas);

    const ctx = canvas.getContext('2d');

    // Extract unique categories and their corresponding data
    const categories = [...new Set(data.map(item => item.x))];
    const datasets = categories.map(category => {
        const categoryData = data.filter(item => item.x === category);
        return {
            label: category,
            data: categoryData.map(item => item.y), // Assuming you want to plot Dim1 values
            backgroundColor: '#FFFFFF', // Use the color from the first item in the category
            itemRadius: 1
        };
    });

    const formatted_data = {
        labels: categories,
        datasets: datasets
    };

    console.log(categories);
    console.log(datasets);

    const config= {
        type: 'violin',
        data: formatted_data,
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Categories'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Values'
                    }
                }
            }
        }
    };

    // Create the violin plot
    const violinPlot = new Chart(ctx, config);
    console.log(violinPlot);
}

function scatterChart(data, color_by) {
    const chartsContainer = document.getElementById('chartsContainer');
    chartsContainer.innerHTML = '';
    const canvas = document.createElement('canvas');
    canvas.id = 'scatter';
    chartsContainer.appendChild(canvas);

    const ctx = canvas.getContext('2d');

    // Extract unique categories and their corresponding data
    const categories = [...new Set(data.map(item => item.x))];
    categories.unshift(''); // Add a blank string at the beginning
    const scatterData = data.map(item => ({
        x: categories.indexOf(item.x) + (Math.random() - 0.5) * 0.2,
        y: item.y, // Assuming you want to plot Dim1 values
        backgroundColor: item.color
    }));

    console.log('data')

    const config = {
        type: 'scatter',
        data: {
            // labels: categories,
            labels: categories.map((category, index) => index), // Use indices as labels
            datasets: [{
                label: `${color_by} Expression`,
                data: scatterData,
                backgroundColor: scatterData.map(item => item.backgroundColor),
                pointBackgroundColor: scatterData.map(item => item.backgroundColor)
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    labels: categories,
                    start: 0,
                    ticks: {
                        callback: function(value, index, values) {
                            return value % 1 === 0 ? categories[index] : '';
                        },
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        color: 'white'
                    },
                    // labels: categories.map((category, index) => index),
                    title: {
                        display: true,
                        text: 'Cell Types',
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        color: 'white'
                    }
                },
                y: {
                    ticks: {
                      font: {
                          weight: 'bold',
                          size: 14
                      },
                        color: 'white'
                    },
                    title: {
                        display: true,
                        text: 'Expression',
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        color: 'white'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        color: 'white'
                    }
                }
            }
        }
    };

    // Rotate x-axis labels
    config.options.scales.x.ticks.autoSkip = false;
    config.options.scales.x.ticks.maxRotation = 35;
    config.options.scales.x.ticks.minRotation = 35;
    config.options.scales.x.ticks.stepSize = 1;

    // Create the scatter plot
    const scatterPlot = new Chart(ctx, config);
    console.log(scatterPlot);
}

window.Chart = Chart;

window.fetchChartData = fetchChartData;
window.splitChart = splitChart;
window.singleChart = singleChart;
window.violinChart = violinChart;
window.scatterChart = scatterChart;

window.sessionConfig = {
    color_by: 'celltypes',
    chart_type: 'UMAP',
    split_plot: false
};