<?php
$settings = \App\Helpers\General::get_settings();
?>
<header>
   <nav class="navbar navbar-zenrooms">
      <div class="container-fluid">
         <div class="navbar-header">
            <div class="side-item">
               <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="offcanvas"
                  data-target="#mobile_menu" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
            </div>
            <a id="logo" class="logo-main navbar-brand" href="/">
            <span class="icon-logo-zenrooms"></span>
            </a>
            <div class="side-item">
               <div class="hidden-sm hidden-md hidden-lg"><a class="navbar-right"
                  data-zen-event='{&#34;name&#34;:&#34;callCustomerCare&#34;,&#34;context&#34;:&#34;Home&#34;}'
                  href="tel:<?=@$settings['hotline']['value']?>">
                  <span class="fa phone-icon icon-ic-247care"></span> <span><?=@$settings['hotline']['value']?></span>
                  </a>
               </div>
            </div>
         </div>
         <div id="nav-moto">
            Travel more, pay less!
         </div>
         <div id="header_menu" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
               <li id="nav-moto-right">
                  <span class="long-text">Budget Travelers' Favorite Hotel Chain</span>
                  <span class="short-text">Budget Travelers' Favorite Hotel Chain</span>
               </li>
               <li id="top_menus" class="nav">
                  <ul>
                     <li class="top-menu">
                        <ul class="switch" id="currency_switch">
                           <li class="dropdown menu-item row">
                              <button type="button"
                                 class="btn btn-transparent dropdown-toggle current-currency"
                                 data-toggle="dropdown">
                              VND <span class="fa fa-angle-down"></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right multi-column columns-4 clearfix ">
                                 <li class="dropdown-menu-header">currency-switch
                                    Select your currency
                                 </li>
                                 <li>
                                    <div class="col-sm-3">
                                       <ul class="selectable-dropdown">
                                          <li class="currency" data-code="IDR">
                                             <a href="#"> <span class="code">IDR</span> <span
                                                class="name">Indonesian Rupiah</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="MYR">
                                             <a href="#"> <span class="code">MYR</span> <span
                                                class="name">Malaysian Ringgit</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="THB">
                                             <a href="#"> <span class="code">THB</span> <span
                                                class="name">Thai Baht</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="SGD">
                                             <a href="#"> <span class="code">SGD</span> <span
                                                class="name">Singapore Dollar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="PHP">
                                             <a href="#"> <span class="code">PHP</span> <span
                                                class="name">Philippine Peso</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="USD">
                                             <a href="#"> <span class="code">USD</span> <span
                                                class="name">US Dollar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="AED">
                                             <a href="#"> <span class="code">AED</span> <span
                                                class="name">Arab Emirates Dirham</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="ARS">
                                             <a href="#"> <span class="code">ARS</span> <span
                                                class="name">Argentine Peso</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="AUD">
                                             <a href="#"> <span class="code">AUD</span> <span
                                                class="name">Australian Dollar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="BGN">
                                             <a href="#"> <span class="code">BGN</span> <span
                                                class="name">Bulgarian Lev</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="BHD">
                                             <a href="#"> <span class="code">BHD</span> <span
                                                class="name">Bahrain Dinar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="BRL">
                                             <a href="#"> <span class="code">BRL</span> <span
                                                class="name">Brazilian Real</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="CAD">
                                             <a href="#"> <span class="code">CAD</span> <span
                                                class="name">Canadian Dollar</span>
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="col-sm-3">
                                       <ul class="selectable-dropdown">
                                          <li class="currency" data-code="CHF">
                                             <a href="#"> <span class="code">CHF</span> <span
                                                class="name">Swiss Franc</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="CNY">
                                             <a href="#"> <span class="code">CNY</span> <span
                                                class="name">Chinese Yuan</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="CZK">
                                             <a href="#"> <span class="code">CZK</span> <span
                                                class="name">Czech Koruna</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="DKK">
                                             <a href="#"> <span class="code">DKK</span> <span
                                                class="name">Danish Krone</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="EUR">
                                             <a href="#"> <span class="code">EUR</span> <span
                                                class="name">Euro</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="FJD">
                                             <a href="#"> <span class="code">FJD</span> <span
                                                class="name">Fiji Dollar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="GBP">
                                             <a href="#"> <span class="code">GBP</span> <span
                                                class="name">British Pound</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="HKD">
                                             <a href="#"> <span class="code">HKD</span> <span
                                                class="name">Hong Kong Dollar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="HUF">
                                             <a href="#"> <span class="code">HUF</span> <span
                                                class="name">Hungarian Forint</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="ILS">
                                             <a href="#"> <span class="code">ILS</span> <span
                                                class="name">New Israeli Sheqel</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="INR">
                                             <a href="#"> <span class="code">INR</span> <span
                                                class="name">Indian Rupee</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="JOD">
                                             <a href="#"> <span class="code">JOD</span> <span
                                                class="name">Jordanian Dinar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="JPY">
                                             <a href="#"> <span class="code">JPY</span> <span
                                                class="name">Japanese Yen</span>
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="col-sm-3">
                                       <ul class="selectable-dropdown">
                                          <li class="currency" data-code="KHR">
                                             <a href="#"> <span class="code">KHR</span> <span
                                                class="name">Cambodian riel</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="KRW">
                                             <a href="#"> <span class="code">KRW</span> <span
                                                class="name">Korean Won</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="KZT">
                                             <a href="#"> <span class="code">KZT</span> <span
                                                class="name">Kazakh Tenge</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="LAK">
                                             <a href="#"> <span class="code">LAK</span> <span
                                                class="name">Lao Kip</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="LKR">
                                             <a href="#"> <span class="code">LKR</span> <span
                                                class="name">Sri Lanka Rupee</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="MVR">
                                             <a href="#"> <span class="code">MVR</span> <span
                                                class="name">Rufiyaa</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="MXN">
                                             <a href="#"> <span class="code">MXN</span> <span
                                                class="name">Mexican Peso</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="NGN">
                                             <a href="#"> <span class="code">NGN</span> <span
                                                class="name">Nigerian Naira</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="NOK">
                                             <a href="#"> <span class="code">NOK</span> <span
                                                class="name">Norwegian Krone</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="NZD">
                                             <a href="#"> <span class="code">NZD</span> <span
                                                class="name">New Zealand Dollar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="OMR">
                                             <a href="#"> <span class="code">OMR</span> <span
                                                class="name">Omani Rial</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="PKR">
                                             <a href="#"> <span class="code">PKR</span> <span
                                                class="name">Pakistan Rupee</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="PLN">
                                             <a href="#"> <span class="code">PLN</span> <span
                                                class="name">Polish Zloty</span>
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="col-sm-3">
                                       <ul class="selectable-dropdown">
                                          <li class="currency" data-code="QAR">
                                             <a href="#"> <span class="code">QAR</span> <span
                                                class="name">Qatari Rial</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="RON">
                                             <a href="#"> <span class="code">RON</span> <span
                                                class="name">Romanian Leu</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="RUB">
                                             <a href="#"> <span class="code">RUB</span> <span
                                                class="name">Russian Ruble</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="SAR">
                                             <a href="#"> <span class="code">SAR</span> <span
                                                class="name">Saudi Riyal</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="SEK">
                                             <a href="#"> <span class="code">SEK</span> <span
                                                class="name">Swedish Krona</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="TRY">
                                             <a href="#"> <span class="code">TRY</span> <span
                                                class="name">Turkish Lira</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="TWD">
                                             <a href="#"> <span class="code">TWD</span> <span
                                                class="name">Taiwan Dollar</span>
                                             </a>
                                          </li>
                                          <li class="currency" data-code="UAH">
                                             <a href="#"> <span class="code">UAH</span> <span
                                                class="name">Ukrainian Grivna</span>
                                             </a>
                                          </li>
                                          <li class="currency selected" data-code="VND">
                                             <span class="code">VND</span> <span class="name">Vietnamese Dong</span>
                                          </li>
                                          <li class="currency" data-code="ZAR">
                                             <a href="#"> <span class="code">ZAR</span> <span
                                                class="name">South African Rand</span>
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                 </li>
                              </ul>
                           </li>
                        </ul>
                     </li>
                     <li class="top-menu">
                        <ul class="switch" id="language_switch">
                           <li class="dropdown menu-item">
                              <button id="current_language" type="button"
                                 class="btn btn-transparent dropdown-toggle" data-toggle="dropdown">
                              <span class="lang lang-en"></span>
                              EN <span class="fa fa-angle-down"></span>
                              </button>
                              <ul class="dropdown-menu">
                                 <li class="dropdown-menu-header">
                                    Select your language
                                 </li>
                                 <li>
                                    <ul class="selectable-dropdown">
                                       <li class="selected">
                                          <a data-code="en">
                                          <span class="lang lang-en"></span>
                                          <span class="name">English/EN</span>
                                          </a>
                                       </li>
                                       <li class="">
                                          <a data-code="id">
                                          <span class="lang lang-id"></span>
                                          <span class="name">Indonesian/ID</span>
                                          </a>
                                       </li>
                                       <li class="">
                                          <a data-code="th">
                                          <span class="lang lang-th"></span>
                                          <span class="name">Thai/TH</span>
                                          </a>
                                       </li>
                                    </ul>
                                 </li>
                              </ul>
                           </li>
                        </ul>
                     </li>
                  </ul>
               </li>
               <li class="hidden-xs"><a class="navbar-right"
                  data-zen-event='{&#34;name&#34;:&#34;callCustomerCare&#34;,&#34;context&#34;:&#34;Home&#34;}'
                  href="tel:+6285574671004">
                  <span class="fa phone-icon icon-ic-247care"></span> <span>+62 855 7467 1004</span>
                  </a>
               </li>
            </ul>
         </div>
         <ul id="mobile_menu"
            class="navmenu navmenu-zenrooms navmenu-fixed-left offcanvas-xs hidden-sm hidden-md hidden-lg">
            <li class="heading hidden-sm hidden-md hidden-lg">
               <div class="logo"><span class="icon-ic-lotus"></span></div>
               Welcome!
            </li>
            <li class="mobile-menu-item">
               <ul class="switch" id="mobile_currency_switch">
                  <li>
                     <span class="fa fa-fw fa-credit-card"></span>
                     <span class="custom-dropdown custom-dropdown--transparent">
                        <select class="custom-dropdown__select custom-dropdown__select--transparent visible-xs currency-switch">
                           <option class="currency" value="IDR" title="IDR">
                              Indonesian Rupiah (IDR)
                           </option>
                           <option class="currency" value="MYR" title="MYR">
                              Malaysian Ringgit (MYR)
                           </option>
                           <option class="currency" value="THB" title="THB">
                              Thai Baht (THB)
                           </option>
                           <option class="currency" value="SGD" title="SGD">
                              Singapore Dollar (SGD)
                           </option>
                           <option class="currency" value="PHP" title="PHP">
                              Philippine Peso (PHP)
                           </option>
                           <option class="currency" value="USD" title="USD">
                              US Dollar (USD)
                           </option>
                           <option class="currency" value="AED" title="AED">
                              Arab Emirates Dirham (AED)
                           </option>
                           <option class="currency" value="ARS" title="ARS">
                              Argentine Peso (ARS)
                           </option>
                           <option class="currency" value="AUD" title="AUD">
                              Australian Dollar (AUD)
                           </option>
                           <option class="currency" value="BGN" title="BGN">
                              Bulgarian Lev (BGN)
                           </option>
                           <option class="currency" value="BHD" title="BHD">
                              Bahrain Dinar (BHD)
                           </option>
                           <option class="currency" value="BRL" title="BRL">
                              Brazilian Real (BRL)
                           </option>
                           <option class="currency" value="CAD" title="CAD">
                              Canadian Dollar (CAD)
                           </option>
                           <option class="currency" value="CHF" title="CHF">
                              Swiss Franc (CHF)
                           </option>
                           <option class="currency" value="CNY" title="CNY">
                              Chinese Yuan (CNY)
                           </option>
                           <option class="currency" value="CZK" title="CZK">
                              Czech Koruna (CZK)
                           </option>
                           <option class="currency" value="DKK" title="DKK">
                              Danish Krone (DKK)
                           </option>
                           <option class="currency" value="EUR" title="EUR">
                              Euro (EUR)
                           </option>
                           <option class="currency" value="FJD" title="FJD">
                              Fiji Dollar (FJD)
                           </option>
                           <option class="currency" value="GBP" title="GBP">
                              British Pound (GBP)
                           </option>
                           <option class="currency" value="HKD" title="HKD">
                              Hong Kong Dollar (HKD)
                           </option>
                           <option class="currency" value="HUF" title="HUF">
                              Hungarian Forint (HUF)
                           </option>
                           <option class="currency" value="ILS" title="ILS">
                              New Israeli Sheqel (ILS)
                           </option>
                           <option class="currency" value="INR" title="INR">
                              Indian Rupee (INR)
                           </option>
                           <option class="currency" value="JOD" title="JOD">
                              Jordanian Dinar (JOD)
                           </option>
                           <option class="currency" value="JPY" title="JPY">
                              Japanese Yen (JPY)
                           </option>
                           <option class="currency" value="KHR" title="KHR">
                              Cambodian riel (KHR)
                           </option>
                           <option class="currency" value="KRW" title="KRW">
                              Korean Won (KRW)
                           </option>
                           <option class="currency" value="KZT" title="KZT">
                              Kazakh Tenge (KZT)
                           </option>
                           <option class="currency" value="LAK" title="LAK">
                              Lao Kip (LAK)
                           </option>
                           <option class="currency" value="LKR" title="LKR">
                              Sri Lanka Rupee (LKR)
                           </option>
                           <option class="currency" value="MVR" title="MVR">
                              Rufiyaa (MVR)
                           </option>
                           <option class="currency" value="MXN" title="MXN">
                              Mexican Peso (MXN)
                           </option>
                           <option class="currency" value="NGN" title="NGN">
                              Nigerian Naira (NGN)
                           </option>
                           <option class="currency" value="NOK" title="NOK">
                              Norwegian Krone (NOK)
                           </option>
                           <option class="currency" value="NZD" title="NZD">
                              New Zealand Dollar (NZD)
                           </option>
                           <option class="currency" value="OMR" title="OMR">
                              Omani Rial (OMR)
                           </option>
                           <option class="currency" value="PKR" title="PKR">
                              Pakistan Rupee (PKR)
                           </option>
                           <option class="currency" value="PLN" title="PLN">
                              Polish Zloty (PLN)
                           </option>
                           <option class="currency" value="QAR" title="QAR">
                              Qatari Rial (QAR)
                           </option>
                           <option class="currency" value="RON" title="RON">
                              Romanian Leu (RON)
                           </option>
                           <option class="currency" value="RUB" title="RUB">
                              Russian Ruble (RUB)
                           </option>
                           <option class="currency" value="SAR" title="SAR">
                              Saudi Riyal (SAR)
                           </option>
                           <option class="currency" value="SEK" title="SEK">
                              Swedish Krona (SEK)
                           </option>
                           <option class="currency" value="TRY" title="TRY">
                              Turkish Lira (TRY)
                           </option>
                           <option class="currency" value="TWD" title="TWD">
                              Taiwan Dollar (TWD)
                           </option>
                           <option class="currency" value="UAH" title="UAH">
                              Ukrainian Grivna (UAH)
                           </option>
                           <option class="currency" selected value="VND" title="VND">
                              Vietnamese Dong (VND)
                           </option>
                           <option class="currency" value="ZAR" title="ZAR">
                              South African Rand (ZAR)
                           </option>
                        </select>
                     </span>
                  </li>
               </ul>
            </li>
            <li class="mobile-menu-item">
               <ul class="switch" id="mobile_language_switch">
                  <li>
                     <span class="lang lang-en"></span>
                     <span class="custom-dropdown custom-dropdown--transparent">
                        <select class="custom-dropdown__select custom-dropdown__select--transparent visible-xs language-switch">
                           <option class="language" selected value="en" title="English">
                              English 
                           </option>
                           <option class="language" value="id" title="Indonesian">
                              Indonesian 
                           </option>
                           <option class="language" value="th" title="Thai">
                              Thai 
                           </option>
                        </select>
                     </span>
                  </li>
               </ul>
            </li>
         </ul>
      </div>
   </nav>
</header>