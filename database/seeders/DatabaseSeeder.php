<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SiteSetting;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@carsales.com',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);

        // Create site settings
        SiteSetting::create([
            'name' => 'FAHRZONE',
            'email' => 'example@fahrzone.com',
            'phone' => '+49 694 1423 4567',
            'whatsapp' => '+49 694 1423 4567',
            'image' => 'settings/default.jpg',
            'description' => 'Your trusted partner for quality cars.',
            'impressum' => "IMPRESSUM

            Angaben gemäß § 5 TMG

            FAHRZONE AUTO AN-& VERKAUF
            Alte Donaustr 9
            93333 Neustadt an der Donau
            Deutschland

            Telefon: +49 176 24786876
            E-Mail: fahrzone@example.com

            Handelsregister: HRB [Nummer]
            Registergericht: Amtsgericht [Stadt]

            Umsatzsteuer-ID gemäß § 27a UStG: DE[Nummer]

            Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:
            [Vor- und Nachname]
            [Adresse wie oben]

            Streitschlichtung:
            Die EU-Kommission stellt eine Plattform zur Online-Streitbeilegung bereit: https://ec.europa.eu/consumers/odr
            Wir nehmen nicht an Streitbeilegungsverfahren teil.

            Haftungsausschluss:
            Wir übernehmen keine Haftung für die Inhalte externer Links. Für den Inhalt verlinkter Seiten sind ausschließlich deren Betreiber verantwortlich. Alle Inhalte dieser Website sind urheberrechtlich geschützt.

            ---

            LEGAL NOTICE

            Legal notice in accordance with § 5 TMG

            FAHRZONE AUTO AN-& VERKAUF
            Alte Donaustr 9
            93333 Neustadt an der Donau
            Germany

            Phone: +49 176 24786876
            Email: fahrzone@example.com

            Trade Register: HRB [Number]
            Register Court: Local Court [City]

            VAT Identification Number in accordance with § 27a UStG: DE[Number]

            Responsible for content in accordance with § 55 Abs. 2 RStV:
            [Full Name]
            [Address as above]

            Dispute Resolution:
            The European Commission provides a platform for online dispute resolution: https://ec.europa.eu/consumers/odr
            We are not willing or obliged to participate in dispute resolution proceedings.

            Disclaimer:
            We assume no liability for the contents of external links. The operators of linked pages are solely responsible for their content. All content on this website is protected by copyright.",

            'datenschutz' => "DATENSCHUTZERKLÄRUNG

            1. Verantwortlicher
            FAHRZONE AUTO AN-& VERKAUF
            Alte Donaustr 9

            93333 Neustadt an der Donau
            Germany
            
            fahrzone@example.com

            2. Server-Logfiles
            Unser Webserver speichert beim Besuch dieser Website möglicherweise technische Daten wie IP-Adressen temporär in Server-Logfiles. Diese Daten werden ausschließlich für technische Zwecke verwendet, nicht von unserer Anwendung gespeichert und nicht an Dritte weitergegeben.

            3. Lokaler Speicher (Local Storage)
            Diese Website verwendet den lokalen Speicher Ihres Browsers, um zuletzt angesehene Fahrzeuge und Favoriten zu speichern. Diese Daten verbleiben ausschließlich in Ihrem Browser, werden nicht an unsere Server übertragen und enthalten keine personenbezogenen Daten.

            4. Kontaktaufnahme
            Wenn Sie uns per E-Mail oder Telefon kontaktieren, werden Ihre Angaben ausschließlich zur Bearbeitung Ihrer Anfrage verwendet und danach nicht weiter gespeichert.

            5. Ihre Rechte
            Sie haben gemäß DSGVO das Recht auf Auskunft, Berichtigung oder Löschung Ihrer personenbezogenen Daten. Kontaktieren Sie uns unter [E-Mail].

            6. Änderungen
            Wir behalten uns vor, diese Datenschutzerklärung jederzeit zu aktualisieren. Die aktuelle Version ist stets auf dieser Seite verfügbar.

            ---

            PRIVACY POLICY

            1. Controller
            FAHRZONE AUTO AN-& VERKAUF

            Alte Donaustr 9
            93333 Neustadt an der Donau
            Germany

            fahrzone@example.com

            2. Server Log Files
            Our web server may temporarily store technical data such as IP addresses in server log files when you visit this website. This data is used for technical purposes only, is not stored by our application and is not shared with third parties.

            3. Local Storage
            This website uses your browser's local storage to save recently viewed vehicles and favourites. This data remains exclusively in your browser, is not transmitted to our servers and contains no personal data.

            4. Contact
            When you contact us by email or phone, your details are used solely to respond to your enquiry and are not stored beyond that purpose.

            5. Your Rights
            Under GDPR you have the right to access, correct or delete any personal data we hold. Contact us at [Email].

            6. Changes
            We reserve the right to update this privacy policy at any time. The current version is always available on this page.",
        ]);
    }
}