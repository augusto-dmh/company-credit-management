import Chart from 'chart.js/auto';

export function initCharts(empresas) {
    if (!empresas || empresas.length === 0) return;

    const creditosCanvas = document.getElementById('creditosChart');
    const percentualCanvas = document.getElementById('percentualChart');

    if (!creditosCanvas || !percentualCanvas) return;

    // Gráfico de Créditos por Empresa (Bar Chart)
    new Chart(creditosCanvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels: empresas.map(e => e.nome.length > 15 ? e.nome.substring(0, 15) + '...' : e.nome),
            datasets: [
                {
                    label: 'ICMS Pago',
                    data: empresas.map(e => parseFloat(e.icms_pago)),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Crédito Possível',
                    data: empresas.map(e => parseFloat(e.credito_possivel)),
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Distribuição de Percentuais (Doughnut)
    const faixas = {
        'Até 10%': empresas.filter(e => e.percentual_credito < 10).length,
        '10% a 20%': empresas.filter(e => e.percentual_credito >= 10 && e.percentual_credito < 20).length,
        '20% a 30%': empresas.filter(e => e.percentual_credito >= 20 && e.percentual_credito < 30).length,
        'Acima de 30%': empresas.filter(e => e.percentual_credito >= 30).length,
    };

    new Chart(percentualCanvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(faixas),
            datasets: [{
                data: Object.values(faixas),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.7)',
                    'rgba(251, 191, 36, 0.7)',
                    'rgba(34, 197, 94, 0.7)',
                    'rgba(59, 130, 246, 0.7)',
                ],
                borderColor: [
                    'rgba(239, 68, 68, 1)',
                    'rgba(251, 191, 36, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(59, 130, 246, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
}

// Expor globalmente para uso no Blade
window.initCharts = initCharts;