<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="shortcut icon" href="/Logo_Hust.png" />
    <title>Bioinformatics</title>
    <style>
        .grid {
            grid-template-columns: 200px auto;
            column-gap: 10px;
        }

        .col-span-2 {
            grid-column: 1/3;
        }
    </style>
</head>

<body>
    <div class="grid">
        <div class="col-span-2">
            <div class="bg-gray-600 text-white h-16">
                <div class="flex flex-row items-center justify-between h-16">
                    <div class="flex-none px-2">
                        <a href="#">TS</a>
                    </div>


                </div>
            </div>
        </div>

        <div class="min-h-screen bg-gray-100">
            <div class="text-center font-bold text-4xl mt-4">Data</div>
            <div class="ml-4 mt-10">
                <ul>
                    <li class="">Temp and humidity</li>
                </ul>
            </div>
        </div>

        <div>
            <div class="wrapper">
                <div id="chart"></div>
            </div>

            <div class="flex">
                <div class="w-60">
                    <label for="hot">Hot bound:</label><span id="oldHot">0</span>
                    <div class="flex">
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="hot" name="hot" placeholder="Set hot bound">
                        <button class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-block" onclick="setHot()">
                            Set
                        </button>
                    </div>
                </div>
                <div class="w-60 ml-5">
                    <label for="cold">Cold bound:</label><span id="oldCold">0</span>
                    <div class="flex">
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="cold" name="cold" placeholder="Set cold bound">
                        <button class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" onclick="setCold()">
                            Set
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    var layout = {
        height: 700,
        yaxis: {
            dtick: 2,
            tickfont: {
                size: 10
            }
        }
    };

    Plotly.plot('chart',
        [{
                y: [0],
                name: 'temp(&deg;C)',
                type: 'scatter'
            },
            {
                y: [0],
                name: 'humidity(%)',
                type: 'scatter'
            }
        ], layout);

    var cnt = 0;

    function getData() {
        axios.get('http://127.0.0.1:8080/getData')
            .then(function(response) {
                // handle success
                Plotly.extendTraces(
                    'chart', {
                        y: [
                            [parseInt(response.data.record1.Temp)],
                            [parseInt(response.data.record1.Humidity)]
                        ]
                    },
                    [0, 1]);
                cnt++;
                if (cnt > 10) {
                    Plotly.relayout('chart', {
                        xaxis: {
                            range: [cnt - 10, cnt]
                        }
                    });
                }

                var oldHot = parseInt(document.getElementById('oldHot').textContent)
                var oldCold = parseInt(document.getElementById('oldCold').textContent)
                var newHot = parseInt(response.data.record1.HotBound)
                var newCold = parseInt(response.data.record1.ColdBound)
                if (newHot != oldHot) document.getElementById('oldHot').innerHTML = newHot.toString();
                if (newCold != oldCold) document.getElementById('oldCold').innerHTML = newCold.toString();
            })

            .catch(function(error) {
                // handle error
                console.log(error);
            })
            .then(function() {
                // always executed
            });
    }

    setInterval(function() {
        getData()
    }, 2000);
</script>
<script>
    function setHot() {
        var temp = document.getElementById('hot').value;
        axios.get('http://127.0.0.1:8080/setHot?t=' + parseInt(temp))
            .then(function(response) {
                console.log(temp)
            })
            .catch(function(error) {
                // handle error
                console.log(error);
            })
            .then(function() {
                // always executed
            });
    }

    function setCold() {
        var temp = document.getElementById('cold').value;
        axios.get('http://127.0.0.1:8080/setCold?t=' + temp)
            .then(function(response) {

            })
            .catch(function(error) {
                // handle error
                console.log(error);
            })
            .then(function() {
                // always executed
            });
    }
</script>

</html>