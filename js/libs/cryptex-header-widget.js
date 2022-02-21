var cryptext_ccn = cryptext_ccn || {};

cryptext_ccn.header = {

	currentccnFsym: 'BTC',
	currentccnTsym: 'USD',

	currentccnFISO: '',
	currentccnTISO: '',

	chartUrl: function () {
		return "https://min-api.cryptocompare.com/data/histohour?fsym=" + this.currentccnFsym + "&tsym=" + this.currentccnTsym + "&limit=120&aggregate=1&e=CCCAGG";
	},
	priceUrl: function () {
		return "https://min-api.cryptocompare.com/data/pricemultifull?fsyms=" + this.currentccnFsym + "&tsyms=" + this.currentccnTsym;
	},

	drawSparkline: function (data) {
		var width = 285;
		var height = 40;
		var x = d3.scaleLinear().range([0, width - 4]);
		var y = d3.scaleLinear().range([height - 8, 0]);
		var line = d3.line()
			.x(function (d) {
				return x(d.time);
			})
			.y(function (d) {
				return y(d.close);
			});
		x.domain(d3.extent(data, function (d) {
			return d.time;
		}));
		y.domain(d3.extent(data, function (d) {
			return d.close;
		}));

		var svgDom = document.createElementNS("http://www.w3.org/2000/svg", "svg");
		svgDom.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");

		var svg = d3.select(svgDom)
			.attr('width', width)
			.attr('height', height);

		svg.append('path')
			.datum(data)
			.attr('class', 'sparkline')
			.attr('d', line);

		svg.append('circle')
			.attr('class', 'sparkcircle')
			.attr('cx', x(data[data.length - 1].time))
			.attr('cy', y(data[data.length - 1].close))
			.attr('r', 3);

		return svg;
	},
	ccnSummaryChartData: function () {
		var xhr = typeof XMLHttpRequest !== 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

		xhr.open('get', cryptext_ccn.header.chartUrl(), true);
		xhr.onreadystatechange = function () {
			var status;
			var data;

			if (xhr.readyState === 4) {
				status = xhr.status;
				if ( status === 200 ) {
					data = JSON.parse(xhr.responseText);

					var sparkline = cryptext_ccn.header.drawSparkline(data.Data, true);
					jQuery('#ccnSummaryGraph').append(sparkline.node());
				}
			}
		};
		xhr.send();
	},
	ccnSummaryRefreshPrices: function () {
		var xhr = typeof XMLHttpRequest !== 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

		xhr.open('get', cryptext_ccn.header.priceUrl(), true);
		xhr.onreadystatechange = function () {
			var status;
			var data;

			var Fsym = cryptext_ccn.header.currentccnFsym;
			var Tsym = cryptext_ccn.header.currentccnTsym;

			if (xhr.readyState === 4) {
				status = xhr.status;
				if (status === 200) {
					data = JSON.parse(xhr.responseText);

					var highElm = document.getElementById('ccnSummaryHigh');
					var lowElm = document.getElementById('ccnSummaryLow');
					var marketCapElm = document.getElementById('ccnSummaryMarketCap');
					var priceCurrentElm = document.getElementById('ccnSummaryPriceCurrent');
					var priceCurrentTime = document.getElementById('ccnSummaryCurrentTime');
					var pricePctChangeElm = document.getElementById('ccnSummaryPricePctChange');

					var d = new Date();
					var date = new Date(( data['RAW'][Fsym][Tsym]['LASTUPDATE'] * 1000 ) + ( d.getTimezoneOffset() * 60000 ));
					var dateWrapper = moment(date);

					(highElm !== null) ? highElm.innerHTML = data.DISPLAY[Fsym][Tsym]['HIGH24HOUR'].replace(/\s+/g, "") : '';
					(lowElm !== null) ? lowElm.innerHTML = data.DISPLAY[Fsym][Tsym]['LOW24HOUR'].replace(/\s+/g, "") : '';
					(marketCapElm !== null) ? marketCapElm.innerHTML = data.DISPLAY[Fsym][Tsym]['MKTCAP'].replace(/\s+/g, "") : '';

					cryptext_ccn.header.currentccnFISO = data['DISPLAY'][Fsym][Tsym]['FROMSYMBOL'];
					cryptext_ccn.header.currentccnTISO = data['DISPLAY'][Fsym][Tsym]['TOSYMBOL'];

					if (pricePctChangeElm) {
						pricePctChangeElm.innerHTML = data['DISPLAY'][Fsym][Tsym]['CHANGEPCT24HOUR']  + '%';
						pricePctChangeElm.dataset.raw = data['DISPLAY'][Fsym][Tsym]['CHANGEPCT24HOUR'];
					}

					if (priceCurrentElm !== null) {
						priceCurrentElm.innerHTML = data.DISPLAY[Fsym][Tsym]['PRICE'].replace(/\s+/g, "");
					}

					if (priceCurrentTime !== null) {
						priceCurrentTime.innerHTML = dateWrapper.format('HH:mm');
						priceCurrentTime.dateTime = date.toISOString();
					}
				}
			}
		};
		xhr.send();
	},

	changeSymbols: function (fsym) {
		var tsym = 'USD';
		var updateChart = fsym !== this.currentccnFsym;
		this.currentccnFsym = fsym;
		this.currentccnTsym = tsym;

		if ( updateChart ) {
			d3.select('#ccnSummaryGraph svg').remove();
			this.ccnSummaryChartData();
		}
		this.ccnSummaryRefreshPrices();
	},

	interval: '',

	init: function () {
		this.ccnSummaryRefreshPrices();
		this.ccnSummaryChartData();
		this.interval = setInterval(this.ccnSummaryRefreshPrices, 30000);
	},
	streamerUrl: 'https://streamer.cryptocompare.com/',
	subscription: function () {
		return ['5~CCCAGG~' + this.currentccnFsym + '~USD'];
	}

};

cryptext_ccn.header.init();
