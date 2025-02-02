This is forked from camroncade/timezone, only difference being the timezone array, which is updated to ensure that each key appears only once. 

e.g. The key 'Asia/Tokyo' appeared thrice in the original array as below...
    '(UTC+09:00) Osaka' => 'Asia/Tokyo',
    '(UTC+09:00) Sapporo' => 'Asia/Tokyo',
    '(UTC+09:00) Tokyo' => 'Asia/Tokyo',

It now appears only once...
    '(UTC+09:00) Tokyo' => 'Asia/Tokyo',

# Timezone Select Form Builder

This is a helper function that creates a select menu including timezones in human-readable format. Each underlying key is the php-friendly name for the timezone, making it easy to immediately store and use them. The array of timezones and their underlying keys were taken from the repository by [tamaspap](https://github.com/tamaspap/timezones).

## Installation

Recommended installation of this package is through composer. Include the following in your project's `composer.json` file:

    "require": {
    	"nirajp/timezone": "0.1"
    }

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the final step is to add the service provider. Open `config/app.php`, and add a new item to the service providers array.

    'Camroncade\Timezone\TimezoneServiceProvider'

Now it's ready for use!

## Usage

### Timezone Convert Helper Functions

The package includes two helper functions that make it easy to deal with displaying and storing timezones, `convertFromUTC()` and `convertToUTC()`:

Each function accepts two required parameters and a third optional parameter dealing with the format of the returned timestamp.

    convertFromUTC($timestamp, $timezone, $format);
    convertToUTC($timestamp, $timezone, $format);

The first parameter accepts a timestamp, the second accepts the name of the timezone that you are converting to/from. The option values associated with the timezones included in the select form builder can be plugged into here as is. Alternatively, you can use any of [PHP's supported timezones](http://php.net/manual/en/timezones.php).

The third parameter is optional, and default is set to `'Y-m-d H:i:s'`, which is how Laravel natively stores datetimes into the database (the `created_at` and `updated_at` columns).

### Select Form Builder

The package also includes a helper function for the creation of the select option. This is created by calling `Timezone::selectForm()`.

The method selectForm accepts four optional parameters, `string selected`, `placeholder`, `array formAttributes`, and `array optionAttributes`. An example of it's use is shown below:

    $selected = 'US/Central';
    $placeholder = 'Select a timezone';
    $formAttributes = array('class' => 'swegForm', 'style' => 'float:left;', 'name' => 'timezone');
    $optionAttributes = array('customValue' => 'true');

    Timezone::selectForm($selected, $placeholder, $formAttributes, $optionAttributes);

Note that the `$selected` parameter matches the string to the values on each option, not the display text. The paratmeters `$formAttributes` and `$optionAttributes` can be used for styling, roles, and generally anything you need. This is useful for applying Twitter Bootstrap styling.

Simply returning `Timezone::selectForm()` will output the following:

	<select>
	<option value="Pacific/Midway">(UTC-11:00) Midway Island</option>
	<option value="Pacific/Samoa">(UTC-11:00) Samoa</option>
	<option value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
	<option value="US/Alaska">(UTC-09:00) Alaska</option>
	<option value="America/Los_Angeles">(UTC-08:00) Pacific Time (US &amp; Canada)</option>
	<option value="America/Tijuana">(UTC-08:00) Tijuana</option>
	<option value="US/Arizona">(UTC-07:00) Arizona</option>
	<option value="America/Chihuahua">(UTC-07:00) Chihuahua</option>
	<option value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
	<option value="US/Mountain">(UTC-07:00) Mountain Time (US &amp; Canada)</option>
	<option value="America/Managua">(UTC-06:00) Central America</option>
	<option value="US/Central">(UTC-06:00) Central Time (US &amp; Canada)</option>
	<option value="America/Mexico_City">(UTC-06:00) Mexico City</option>
	<option value="America/Monterrey">(UTC-06:00) Monterrey</option>
	<option value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan</option>
	<option value="America/Bogota">(UTC-05:00) Bogota</option>
	<option value="US/Eastern">(UTC-05:00) Eastern Time (US &amp; Canada)</option>
	<option value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
	<option value="America/Lima">(UTC-05:00) Lima</option>
	<option value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)</option>
	<option value="America/Caracas">(UTC-04:30) Caracas</option>
	<option value="America/La_Paz">(UTC-04:00) La Paz</option>
	<option value="America/Santiago">(UTC-04:00) Santiago</option>
	<option value="Canada/Newfoundland">(UTC-03:30) Newfoundland</option>
	<option value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
	<option value="America/Argentina/Buenos_Aires">(UTC-03:00) Buenos Aires</option>
	<option value="America/Godthab">(UTC-03:00) Greenland</option>
	<option value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
	<option value="Atlantic/Azores">(UTC-01:00) Azores</option>
	<option value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.</option>
	<option value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
	<option value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time : Dublin</option>
	<option value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
	<option value="Europe/London">(UTC+00:00) London</option>
	<option value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
	<option value="UTC">(UTC+00:00) UTC</option>
	<option value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
	<option value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
	<option value="Europe/Berlin">(UTC+01:00) Berlin</option>
	<option value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
	<option value="Europe/Brussels">(UTC+01:00) Brussels</option>
	<option value="Europe/Budapest">(UTC+01:00) Budapest</option>
	<option value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
	<option value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
	<option value="Europe/Madrid">(UTC+01:00) Madrid</option>
	<option value="Europe/Paris">(UTC+01:00) Paris</option>
	<option value="Europe/Prague">(UTC+01:00) Prague</option>
	<option value="Europe/Rome">(UTC+01:00) Rome</option>
	<option value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
	<option value="Europe/Skopje">(UTC+01:00) Skopje</option>
	<option value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
	<option value="Europe/Vienna">(UTC+01:00) Vienna</option>
	<option value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
	<option value="Africa/Lagos">(UTC+01:00) West Central Africa</option>
	<option value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
	<option value="Europe/Athens">(UTC+02:00) Athens</option>
	<option value="Europe/Bucharest">(UTC+02:00) Bucharest</option>
	<option value="Africa/Cairo">(UTC+02:00) Cairo</option>
	<option value="Africa/Harare">(UTC+02:00) Harare</option>
	<option value="Europe/Helsinki">(UTC+02:00) Helsinki</option>
	<option value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
	<option value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
	<option value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
	<option value="Europe/Riga">(UTC+02:00) Riga</option>
	<option value="Europe/Sofia">(UTC+02:00) Sofia</option>
	<option value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
	<option value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
	<option value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
	<option value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
	<option value="Europe/Minsk">(UTC+03:00) Minsk</option>
	<option value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
	<option value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
	<option value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
	<option value="Asia/Tehran">(UTC+03:30) Tehran</option>
	<option value="Asia/Baku">(UTC+04:00) Baku</option>
	<option value="Europe/Moscow">(UTC+04:00) Moscow</option>
	<option value="Asia/Muscat">(UTC+04:00) Muscat</option>
	<option value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
	<option value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
	<option value="Asia/Kabul">(UTC+04:30) Kabul</option>
	<option value="Asia/Karachi">(UTC+05:00) Karachi</option>
	<option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
	<option value="Asia/Calcutta" selected="selected">(UTC+05:30) Mumbai</option>
	<option value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
	<option value="Asia/Almaty">(UTC+06:00) Almaty</option>
	<option value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
	<option value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
	<option value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
	<option value="Asia/Bangkok">(UTC+07:00) Bangkok</option>
	<option value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
	<option value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
	<option value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
	<option value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
	<option value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
	<option value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
	<option value="Australia/Perth">(UTC+08:00) Perth</option>
	<option value="Asia/Singapore">(UTC+08:00) Singapore</option>
	<option value="Asia/Taipei">(UTC+08:00) Taipei</option>
	<option value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
	<option value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
	<option value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
	<option value="Asia/Seoul">(UTC+09:00) Seoul</option>
	<option value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
	<option value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
	<option value="Australia/Darwin">(UTC+09:30) Darwin</option>
	<option value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
	<option value="Australia/Canberra">(UTC+10:00) Canberra</option>
	<option value="Pacific/Guam">(UTC+10:00) Guam</option>
	<option value="Australia/Hobart">(UTC+10:00) Hobart</option>
	<option value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
	<option value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby</option>
	<option value="Australia/Sydney">(UTC+10:00) Sydney</option>
	<option value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
	<option value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
	<option value="Pacific/Auckland">(UTC+12:00) Auckland</option>
	<option value="Pacific/Fiji">(UTC+12:00) Fiji</option>
	<option value="Pacific/Kwajalein">(UTC+12:00) International Date Line West</option>
	<option value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
	<option value="Asia/Magadan">(UTC+12:00) Magadan</option>
	<option value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
	</select>
