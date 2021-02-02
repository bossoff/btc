
                  <!-- Banner/Slider -->
                  <div class="page-head section row-vm light">
                        <div class="imagebg">
                              <img src="<?=base_url();?>web/images/page-bitcoin-bg.jpg" alt="page-head">
                        </div>
                        <div class="container">
                              <div class="row text-center">
                                    <div class="col-md-12">
                                          <h2><?=ucwords(strtolower($page_title));?></h2>
                                          <div class="page-breadcrumb">
                                                <ul class="breadcrumb">
                                                      <li><a href="index.html">Home</a></li>
                                                      <li class="active"><span><?=ucwords(strtolower($page_title));?></span></li>
                                                </ul>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <!-- #end Banner/Slider -->
            </header>
                  
            <!--Section -->
            <div class="section section-pad bg-grey">
                  <div class="container">
                        <div class="row row-vm">
                              <div class="col-md-6">
                                    <div class="trendingview-chart res-m-bttm">
                                          <!-- TradingView Widget BEGIN -->
                                          <script src="https://s3.tradingview.com/tv.js"></script>
                                          <script>
                                          new TradingView.widget({
                                                "autosize":true,
                                                "symbol": "BTC",
                                                "interval": "60",
                                                "timezone": "Etc/UTC",
                                                "theme": "Light",
                                                "style": "1",
                                                "locale": "en",
                                                "toolbar_bg": "#f1f3f6",
                                                "enable_publishing": false,
                                                "allow_symbol_change": true,
                                                "hideideas": true
                                          });
                                          </script>
                                          <!-- TradingView Widget END -->
                                    </div>
                              </div>
                              <div class="col-md-5 col-md-offset-1 ">
                                    <div class="text-block">
                                          <h2>No Experience? <br/>No worries</h2>
                                          <p>Looking to get started in the world of cryptocurrency trading sit amet tristique?</p>
                                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et lorem nec felis finibus laoreet. Nullam id dictum urna. Vestibulum in aliquam tellus, sit amet tristique ipsum. </p>
                                          <a href="<?=base_url();?>investment" class="btn btn-alt">get started</a>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <!--End Section -->
            
            <!--Section -->
            <div class="section section-pad">
                  <div class="container">
                        <div class="row row-vm reverses">
                              <div class="col-md-6 res-m-bttm">
                                    <div class="trendingview-chart res-m-bttm">
                                          <!-- TradingView Widget BEGIN -->
                                          <div id="tv-medium-widget-one"></div>
                                          <script src="https://s3.tradingview.com/tv.js"></script>
                                          <script>
                                          new TradingView.MediumWidget({
                                            "container_id": "tv-medium-widget-one",
                                            "symbols": [
                                                [
                                                  "Apple",
                                                  "AAPL "
                                                ],
                                                [
                                                  "Google",
                                                  "GOOGL"
                                                ],
                                                [
                                                  "Microsoft",
                                                  "MSFT"
                                                ]
                                            ],
                                            "greyText": "Quotes by",
                                            "gridLineColor": "#e9e9ea",
                                            "fontColor": "#83888D",
                                            "underLineColor": "#dbeffb",
                                            "trendLineColor": "#4bafe9",
                                            "width": "100%",
                                            "height": "100%",
                                            "locale": "en"
                                          });
                                          </script>
                                          <!-- TradingView Widget END -->
                                    </div>
                              </div>
                              <div class="col-md-5 col-md-offset-1">
                                    <div class="text-block">
                                          <h2>Take a Look at<br/>Crypto Stock Chart</h2>
                                          <p>Looking to get started in the world of cryptocurrency trading sit amet tristique?</p>
                                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et lorem nec felis finibus laoreet. Nullam id dictum urna. Vestibulum in aliquam tellus, sit amet tristique ipsum. </p>
                                          <a href="<?=base_url();?>investment" class="btn btn-alt">get started</a>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <!--End Section -->

            <!--Section -->
            <div class="section section-pad bg-grey">
                  <div class="container">
                        <div class="row">
                              <div class="col-md-10 col-md-offset-1">
                                    <div class="trendingview-chart">
                                          <!-- TradingView Widget BEGIN -->
                                          <script src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js">
                                          {"currencies": [
                                                "EUR",
                                                "USD",
                                                "JPY",
                                                "GBP",
                                                "CHF",
                                                "AUD",
                                                "CAD",
                                                "NZD",
                                                "CNY"
                                            ],
                                            "width": "100%",
                                            "height": "100%",
                                            "locale": "en",
                                            "largeChartUrl": "market-data.html" }
                                          </script>
                                          <!-- TradingView Widget END -->
                                    </div>
                              </div>
                        </div>
                        <div class="gaps size-2x"></div>
                        <div class="row text-center">
                              <div class="col-md-8 col-md-offset-2">
                                    <div class="text-block">
                                          <h2>Take a Look at<br/>Crypto Stock Chart</h2>
                                          <p>Looking to get started in the world of cryptocurrency trading sit amet tristique? Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et lorem nec felis finibus laoreet. Nullam id dictum urna. Vestibulum in aliquam tellus, sit amet tristique ipsum. </p>
                                          <a href="<?=base_url();?>investment" class="btn btn-alt">get started</a>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <!--End Section -->

           
