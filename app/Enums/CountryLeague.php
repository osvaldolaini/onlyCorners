<?php

namespace App\Enums;

enum CountryLeague: string
{
    // === EUROPA (principais ligas) ===
    case England    = 'england';     // Premier League
    case Spain      = 'spain';       // La Liga
    case Italy      = 'italy';       // Serie A
    case Germany    = 'germany';     // Bundesliga
    case France     = 'france';      // Ligue 1
    case Portugal   = 'portugal';    // Primeira Liga
    case Netherlands = 'netherlands'; // Eredivisie
    case Russia     = 'russia';      // Premier League Russa
    case Turkey     = 'turkey';      // Süper Lig
    case Belgium    = 'belgium';     // Pro League

        // === AMÉRICAS ===
        // América do Sul
    case Brasil     = 'brasil';      // Brasileirão Série A
    case Argentina  = 'argentina';   // Liga Profesional
    case Uruguay    = 'uruguay';     // Primera División
    case Colombia   = 'colombia';    // Categoría Primera A
    case Chile      = 'chile';       // Primera División
    case Paraguay   = 'paraguay';    // Primera División
    case Ecuador    = 'ecuador';     // Liga Pro
    case Peru       = 'peru';        // Liga 1
    case Bolivia    = 'bolivia';     // División Profesional

        // América do Norte / Central
    case UnitedStates = 'united_states'; // Major League Soccer (MLS)
    case Mexico     = 'mexico';      // Liga MX
    case Canada     = 'canada';      // Canadian Premier League

    /**
     * Retorna o nome completo do país (em português)
     */
    public function label(): string
    {
        return match ($this) {
            self::England       => 'Inglaterra',
            self::Spain         => 'Espanha',
            self::Italy         => 'Itália',
            self::Germany       => 'Alemanha',
            self::France        => 'França',
            self::Portugal      => 'Portugal',
            self::Netherlands   => 'Países Baixos',
            self::Russia        => 'Rússia',
            self::Turkey        => 'Turquia',
            self::Belgium       => 'Bélgica',

            self::Brasil        => 'Brasil',
            self::Argentina     => 'Argentina',
            self::Uruguay       => 'Uruguai',
            self::Colombia      => 'Colômbia',
            self::Chile         => 'Chile',
            self::Paraguay      => 'Paraguai',
            self::Ecuador       => 'Equador',
            self::Peru          => 'Peru',
            self::Bolivia       => 'Bolívia',

            self::UnitedStates  => 'Estados Unidos',
            self::Mexico        => 'México',
            self::Canada        => 'Canadá',
        };
    }

    /**
     * Retorna o nome da liga mais importante do país
     */
    public function leagueName(): string
    {
        return match ($this) {
            self::England       => 'Premier League',
            self::Spain         => 'La Liga',
            self::Italy         => 'Serie A',
            self::Germany       => 'Bundesliga',
            self::France        => 'Ligue 1',
            self::Portugal      => 'Primeira Liga',
            self::Netherlands   => 'Eredivisie',
            self::Russia        => 'Premier League Russa',
            self::Turkey        => 'Süper Lig',
            self::Belgium       => 'Pro League',

            self::Brasil        => 'Brasileirão Série A',
            self::Argentina     => 'Liga Profesional',
            self::Uruguay       => 'Primera División',
            self::Colombia      => 'Categoría Primera A',
            self::Chile         => 'Primera División',
            self::Paraguay      => 'Primera División',
            self::Ecuador       => 'Liga Pro',
            self::Peru          => 'Liga 1',
            self::Bolivia       => 'División Profesional',

            self::UnitedStates  => 'Major League Soccer (MLS)',
            self::Mexico        => 'Liga MX',
            self::Canada        => 'Canadian Premier League',
        };
    }

    /**
     * Retorna a bandeira do país (emoji)
     */
    public function flag(): string
    {
        return match ($this) {
            self::England       => '🇬🇧',
            self::Spain         => '🇪🇸',
            self::Italy         => '🇮🇹',
            self::Germany       => '🇩🇪',
            self::France        => '🇫🇷',
            self::Portugal      => '🇵🇹',
            self::Netherlands   => '🇳🇱',
            self::Russia        => '🇷🇺',
            self::Turkey        => '🇹🇷',
            self::Belgium       => '🇧🇪',

            self::Brasil        => '🇧🇷',
            self::Argentina     => '🇦🇷',
            self::Uruguay       => '🇺🇾',
            self::Colombia      => '🇨🇴',
            self::Chile         => '🇨🇱',
            self::Paraguay      => '🇵🇾',
            self::Ecuador       => '🇪🇨',
            self::Peru          => '🇵🇪',
            self::Bolivia       => '🇧🇴',

            self::UnitedStates  => '🇺🇸',
            self::Mexico        => '🇲🇽',
            self::Canada        => '🇨🇦',
        };
    }

    /**
     * Retorna o código ISO do país (útil para APIs, bancos, etc)
     */
    public function isoCode(): string
    {
        return match ($this) {
            self::England       => 'GB',
            self::Spain         => 'ES',
            self::Italy         => 'IT',
            self::Germany       => 'DE',
            self::France        => 'FR',
            self::Portugal      => 'PT',
            self::Netherlands   => 'NL',
            self::Russia        => 'RU',
            self::Turkey        => 'TR',
            self::Belgium       => 'BE',

            self::Brasil        => 'BR',
            self::Argentina     => 'AR',
            self::Uruguay       => 'UY',
            self::Colombia      => 'CO',
            self::Chile         => 'CL',
            self::Paraguay      => 'PY',
            self::Ecuador       => 'EC',
            self::Peru          => 'PE',
            self::Bolivia       => 'BO',

            self::UnitedStates  => 'US',
            self::Mexico        => 'MX',
            self::Canada        => 'CA',
        };
    }
}
