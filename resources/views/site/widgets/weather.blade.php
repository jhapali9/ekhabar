<div class="sg-widget">
    <h3 class="widget-title">{{ __('weather') }}</h3>
    <div class="weather-widget">
        <div class="date-time">
            <h4>{{ __('today') }}</h4>
            <p>{{date('l, d F Y')}}</p>
        </div>
        <div class="d-flex justify-content-md-between">
            <div class="left-content">
                <h4>{{@$weatherInfo['cityName']}}</h4>
                {{-- <h5>Khilkhet, Purbonamapara</h5> --}}
                <div class="temp">
                    <div class="icon my-3">
                        <svg class="mr-3" data-name="Group 308" xmlns="http://www.w3.org/2000/svg" width="53.5" height="53.5" viewBox="0 0 53.5 53.5">
                            <g>
                                <g>
                                    <path data-name="Path 150" d="M27.4,426.768a1.1,1.1,0,0,0-1.171.114l-3.468,2.65a3.29,3.29,0,0,0-1.428,2.693,3.344,3.344,0,0,0,6.688,0v-4.458A1.117,1.117,0,0,0,27.4,426.768Zm-1.609,5.458a1.115,1.115,0,1,1-2.229,0,1.1,1.1,0,0,1,.5-.883.329.329,0,0,0,.037-.027l1.691-1.293Z" transform="translate(-19.104 -382.069)" fill="#484848"/>
                                    <path data-name="Path 151" d="M198.067,426.768a1.1,1.1,0,0,0-1.171.114l-3.468,2.65A3.29,3.29,0,0,0,192,432.225a3.344,3.344,0,0,0,6.688,0v-4.458A1.117,1.117,0,0,0,198.067,426.768Zm-1.609,5.458a1.115,1.115,0,0,1-2.229,0,1.1,1.1,0,0,1,.5-.883.329.329,0,0,0,.037-.027l1.692-1.293Z" transform="translate(-171.938 -382.069)" fill="#484848"/>
                                    <path data-name="Path 152" d="M368.733,426.768a1.1,1.1,0,0,0-1.171.114l-3.466,2.651a3.281,3.281,0,0,0-1.43,2.692,3.344,3.344,0,0,0,6.688,0v-4.458A1.116,1.116,0,0,0,368.733,426.768Zm-1.609,5.458a1.115,1.115,0,1,1-2.229,0,1.09,1.09,0,0,1,.5-.881l.037-.028,1.692-1.293v2.2Z" transform="translate(-324.77 -382.069)" fill="#484848"/>
                                    <path data-name="Path 153" d="M42.354,8.917a11.145,11.145,0,0,0-2.538.321A15.545,15.545,0,0,0,10.14,14a8.913,8.913,0,0,0-5.682,8.287,8.13,8.13,0,0,0,.186,1.6,10.013,10.013,0,0,0,5.387,18.466h3.394l-.852.651A3.29,3.29,0,0,0,11.146,45.7a3.344,3.344,0,1,0,6.687,0V42.354H31.259l-.852.651A3.29,3.29,0,0,0,28.979,45.7a3.344,3.344,0,0,0,6.688,0V42.241a7.791,7.791,0,0,0,6.688-7.689,7.711,7.711,0,0,0-.783-3.344h.783a11.146,11.146,0,1,0,0-22.292ZM15.6,45.7a1.115,1.115,0,1,1-2.229,0,1.1,1.1,0,0,1,.5-.883.328.328,0,0,0,.037-.027L15.6,43.495v2.2Zm17.833,0a1.115,1.115,0,1,1-2.229,0,1.1,1.1,0,0,1,.5-.883.328.328,0,0,0,.037-.027l1.692-1.293Zm1.115-5.573H10.031a7.8,7.8,0,1,1,0-15.6,7.72,7.72,0,0,1,4.874,1.709A1.114,1.114,0,1,0,16.3,24.49a9.933,9.933,0,0,0-1.461-.966A11.078,11.078,0,0,1,35.4,26.836a7.635,7.635,0,0,0-.848-.086,1.115,1.115,0,0,0,0,2.229,5.573,5.573,0,0,1,0,11.146Zm7.8-11.146H40a7.826,7.826,0,0,0-2.216-1.51A13.324,13.324,0,0,0,12.754,22.7a10,10,0,0,0-2.723-.412,9.909,9.909,0,0,0-3.294.6,5.553,5.553,0,0,1-.05-.6A6.7,6.7,0,0,1,13.375,15.6a1.115,1.115,0,1,0,0-2.229,8.734,8.734,0,0,0-.942.1,13.333,13.333,0,0,1,25.26-3.526,11.141,11.141,0,0,0-1.558.866,1.115,1.115,0,1,0,1.245,1.85,8.917,8.917,0,1,1,4.974,16.318Z" fill="#484848"/>
                                </g>
                            </g>
                        </svg>
                        <span>{{@$weatherInfo['Celsius']}}°C</span>
                    </div>
                </div>
            </div><!-- /.left-content -->

            <div class="right-content">
                <div class="icon mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <g  data-name="Group 309" transform="translate(-1809 -1780)">
                            <g transform="translate(1809 1780)">
                                <path data-name="Path 148" d="M.31,9.931H1.924a7.145,7.145,0,0,0,6.145,6.145V17.69a.311.311,0,0,0,.31.31H9.621a.311.311,0,0,0,.31-.31V16.076a7.145,7.145,0,0,0,6.145-6.145H17.69a.311.311,0,0,0,.31-.31V8.379a.311.311,0,0,0-.31-.31H16.076A7.145,7.145,0,0,0,9.931,1.924V.31A.311.311,0,0,0,9.621,0H8.379a.311.311,0,0,0-.31.31V1.924A7.145,7.145,0,0,0,1.924,8.069H.31a.311.311,0,0,0-.31.31V9.621a.311.311,0,0,0,.31.31ZM9,3.724A5.276,5.276,0,1,1,3.724,9,5.276,5.276,0,0,1,9,3.724Zm0,0" fill="#484848"/>
                                <path data-name="Path 149" d="M190.344,187.862a2.483,2.483,0,1,1-2.483-2.483A2.483,2.483,0,0,1,190.344,187.862Zm0,0" transform="translate(-178.862 -178.862)" fill="#484848"/>
                            </g>
                        </g>
                    </svg>
                </div>
                <p><i class="fa fa-angle-double-up" aria-hidden="true"></i> <span>0.6°</span></p>
                <p><i class="fa fa-angle-double-down" aria-hidden="true"></i> <span>8.3°C</span></p>
            </div><!-- /.right-content -->
        </div>

        <ul class="global-list d-flex justify-content-md-between middle-content">
            <li>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="9.58" viewBox="0 0 6 9.58">
                      <g data-name="Group 310" transform="translate(-35.275 0)">
                        <g data-name="Group 266" transform="translate(35.275 0)">
                          <path data-name="Path 155" d="M38.626.33c-.23-.448-.473-.432-.7,0-1.054,1.791-2.649,4.478-2.649,5.822a3.694,3.694,0,0,0,.878,2.424,2.744,2.744,0,0,0,4.243,0,3.694,3.694,0,0,0,.878-2.424C41.275,4.793,39.68,2.122,38.626.33Zm1.811,7.351a2.763,2.763,0,0,1-.905,1,.332.332,0,0,1-.486-.154.437.437,0,0,1,.135-.571,1.921,1.921,0,0,0,.649-.71,2.221,2.221,0,0,0,.27-.988.373.373,0,0,1,.378-.386.387.387,0,0,1,.338.432A3.376,3.376,0,0,1,40.437,7.681Z" transform="translate(-35.275 0)" fill="#484848"/>
                        </g>
                      </g>
                    </svg>
                </span>
                87 %
            </li>
            <li>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="10.5" height="10.5" viewBox="0 0 10.5 10.5">
                      <g data-name="Group 311" transform="translate(-1667.5 -1921.5)">
                        <g transform="translate(1678 1921.5) rotate(90)">
                          <path data-name="Path 156" d="M1.321,153.986a.308.308,0,0,0,.525-.217v-.615H3.4a1.232,1.232,0,0,1,1.231,1.231V158.1a.307.307,0,0,0,.308.308h.615a.307.307,0,0,0,.308-.308v-3.712A2.464,2.464,0,0,0,3.4,151.923H1.846v-.615a.308.308,0,0,0-.525-.217L.09,152.32a.307.307,0,0,0,0,.435Zm0,0" transform="translate(0 -147.903)" fill="#484848"/>
                          <path data-name="Path 157" d="M182.539,4.036a3.063,3.063,0,0,1,.615-.37V1.846h.615a.308.308,0,0,0,.218-.525L182.756.09a.308.308,0,0,0-.435,0l-1.23,1.231a.308.308,0,0,0,.217.525h.615V3.666A3.063,3.063,0,0,1,182.539,4.036Zm0,0" transform="translate(-177.289 0)" fill="#484848"/>
                          <path data-name="Path 158" d="M281.512,151.089a.308.308,0,0,0-.525.218v.615h-1.559a2.444,2.444,0,0,0-1.394.436,3.058,3.058,0,0,1,.615,1.08,1.218,1.218,0,0,1,.779-.286h1.559v.615a.308.308,0,0,0,.525.217l1.23-1.23a.307.307,0,0,0,0-.435Zm0,0" transform="translate(-272.333 -147.902)" fill="#484848"/>
                        </g>
                      </g>
                    </svg>
                </span>
                6.7 kmh
            </li>
            <li>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="9.736" height="9.333" viewBox="0 0 9.736 9.333">
                      <g data-name="Group 312" transform="translate(-1794.534 -1921.667)">
                        <path d="M6.806,11.985a2.5,2.5,0,0,0-4.868.985,1.993,1.993,0,0,0-.457,3.917l-.046.52a.314.314,0,0,0,.313.342h.869l-.141,1.381a.314.314,0,0,0,.573.207l1.606-2.384H7.233a2.5,2.5,0,1,0-.428-4.969ZM3.227,17.946l.049-.48a.314.314,0,0,0-.312-.346H2.09l.141-1.589,1.077,0-.2.783a.314.314,0,0,0,.3.391h.646ZM2.127,16.7l.007-.081A.3.3,0,0,1,2.127,16.7ZM5.42,18.186a.314.314,0,0,1-.087-.436l.2-.294a.314.314,0,0,1,.523.348l-.2.294A.314.314,0,0,1,5.42,18.186Zm-.885,1.353a.314.314,0,0,1-.084-.436l.373-.55a.314.314,0,1,1,.52.353l-.373.55a.314.314,0,0,1-.436.084Zm2.652-1.353a.314.314,0,0,1-.087-.436l.2-.294a.314.314,0,1,1,.523.348l-.2.294A.314.314,0,0,1,7.186,18.186ZM6.3,19.539a.314.314,0,0,1-.084-.436l.373-.55a.314.314,0,1,1,.52.353l-.373.55A.314.314,0,0,1,6.3,19.539Z" transform="translate(1794.535 1911.407)" fill="#484848"/>
                      </g>
                    </svg>
                </span>
                100 %
            </li>
        </ul>
        <ul class="global-list d-flex justify-content-between botton-content">
            <li>Sat <span>11°</span></li>
            <li>Sun<span>9°</span></li>
            <li>Mon<span>13°</span></li>
            <li>Tue<span>7°</span></li>
            <li>Wed<span>12°</span></li>
            <li>Thu<span>9°</span></li>
            <li>Fri<span>8°</span></li>
        </ul>
    </div>
    {{--                        <!-- /.weather-widget -->--}}
</div>
