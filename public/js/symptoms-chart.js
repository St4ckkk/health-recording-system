document.addEventListener('DOMContentLoaded', function () {
    // Prepare data for the symptoms doughnut chart
    const symptomsChartElement = document.getElementById('symptomsChart');
    if (symptomsChartElement) {
        const ctx = symptomsChartElement.getContext('2d');

        // Get data from PHP variables passed to the page
        const presentCount = parseInt(document.getElementById('symptomCount')?.value || 0);
        const absentCount = parseInt(document.getElementById('totalSymptoms')?.value || 0) - presentCount;
        const probability = parseInt(document.getElementById('probability')?.value || 0);

        const data = {
            labels: ['Present Symptoms', 'Absent Symptoms'],
            datasets: [{
                data: [presentCount, absentCount],
                backgroundColor: [
                    probability < 30 ? "rgba(16, 185, 129, 0.8)" :
                        (probability < 70 ? "rgba(245, 158, 11, 0.8)" : "rgba(239, 68, 68, 0.8)"),
                    'rgba(209, 213, 219, 0.8)'
                ],
                borderColor: [
                    probability < 30 ? "rgb(16, 185, 129)" :
                        (probability < 70 ? "rgb(245, 158, 11)" : "rgb(239, 68, 68)"),
                    'rgb(209, 213, 219)'
                ],
                borderWidth: 1,
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            boxWidth: 12,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        },
                        titleFont: {
                            family: "'Inter', sans-serif"
                        },
                        bodyFont: {
                            family: "'Inter', sans-serif"
                        },
                        padding: 12,
                        boxPadding: 6
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        };

        new Chart(ctx, config);
    }

    // Animate the probability bar on load
    const probabilityBar = document.querySelector('.h-3 .absolute');
    if (probabilityBar) {
        const probability = parseInt(document.getElementById('probability')?.value || 0);
        probabilityBar.style.width = '0%';
        setTimeout(() => {
            probabilityBar.style.width = probability + '%';
        }, 300);
    }

    // Create the category chart (radar chart)
    const createCategoryChart = () => {
        const categoryCtx = document.getElementById('categoryChart');
        if (!categoryCtx) return;

        const respiratoryPercentage = parseInt(document.getElementById('respiratoryPercentage')?.value || 0);
        const generalPercentage = parseInt(document.getElementById('generalPercentage')?.value || 0);
        const otherPercentage = parseInt(document.getElementById('otherPercentage')?.value || 0);

        new Chart(categoryCtx, {
            type: 'radar',
            data: {
                labels: ['Respiratory', 'General', 'Other'],
                datasets: [{
                    label: 'Symptom Categories',
                    data: [respiratoryPercentage, generalPercentage, otherPercentage],
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(99, 102, 241, 1)'
                }]
            },
            options: {
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: 0,
                        suggestedMax: 100,
                        ticks: {
                            stepSize: 20
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    };

    // Create the treatment timeline chart
    const createTreatmentTimelineChart = () => {
        const timelineCtx = document.getElementById('treatmentTimelineChart');
        if (!timelineCtx) return;

        const treatmentDuration = parseInt(document.getElementById('treatmentDuration')?.value || 0);
        if (treatmentDuration <= 0) return;

        // Calculate phases based on treatment duration
        const intensivePhase = Math.min(8, Math.round(treatmentDuration * 0.3));
        const continuationPhase = treatmentDuration - intensivePhase;

        new Chart(timelineCtx, {
            type: 'bar',
            data: {
                labels: ['Intensive Phase', 'Continuation Phase'],
                datasets: [{
                    label: 'Duration (weeks)',
                    data: [intensivePhase, continuationPhase],
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(59, 130, 246, 0.7)'
                    ],
                    borderColor: [
                        'rgb(239, 68, 68)',
                        'rgb(59, 130, 246)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Weeks'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    };

    // Animate the severity gauge
    const animateSeverityGauge = () => {
        const severityGauge = document.getElementById('severityGauge');
        if (!severityGauge) return;

        const severityScore = parseInt(document.getElementById('severityScore')?.value || 0);
        const percentage = (severityScore / 10) * 100;

        severityGauge.style.width = '0%';
        setTimeout(() => {
            severityGauge.style.width = percentage + '%';
        }, 500);
    };

    // Call all chart creation functions
    createCategoryChart();
    createTreatmentTimelineChart();
    animateSeverityGauge();
});