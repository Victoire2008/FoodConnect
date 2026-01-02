<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ville;
use App\Models\Commune;

class VilleCommuneSeeder extends Seeder
{
    public function run(): void
    {
        // Villes
        $villes = [
            'Abidjan',
            'Bouaké',
            'Daloa',
            'Yamoussoukro',
            'San-Pédro',
            'Korhogo',
            'Man',
            'Gagnoa',
            'Abengourou',
            'Divo'
        ];

        foreach ($villes as $villeName) {
            Ville::create(['name' => $villeName]);
        }

        // Communes pour Abidjan
        $communesAbidjan = [
            'Plateau',
            'Cocody',
            'Marcory',
            'Treichville',
            'Yopougon',
            'Koumassi',
            'Port-Bouët',
            'Adjame',
            'Attécoubé',
            'Bingerville'
        ];

        $abidjan = Ville::where('name', 'Abidjan')->first();
        foreach ($communesAbidjan as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $abidjan->id
            ]);
        }

        // Communes pour Bouaké
        $communesBouake = [
            'Bouaké Centre',
            'Dar-es-Salam',
            'N\'Gatikpi',
            'Koko'
        ];

        $bouake = Ville::where('name', 'Bouaké')->first();
        foreach ($communesBouake as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $bouake->id
            ]);
        }

        // Communes pour Daloa
        $communesDaloa = [
            'Daloa Centre',
            'Gbon',
            'Zoukougbeu'
        ];

        $daloa = Ville::where('name', 'Daloa')->first();
        foreach ($communesDaloa as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $daloa->id
            ]);
        }

        // Communes pour Yamoussoukro
        $communesYamoussoukro = [
            'Yamoussoukro Centre',
            'Morofé',
            'N\'Gokro'
        ];

        $yamoussoukro = Ville::where('name', 'Yamoussoukro')->first();
        foreach ($communesYamoussoukro as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $yamoussoukro->id
            ]);
        }

        // Communes pour San-Pédro
        $communesSanPedro = [
            'San-Pédro Centre',
            'Grand-Béréby',
            'Tabou'
        ];

        $sanPedro = Ville::where('name', 'San-Pédro')->first();
        foreach ($communesSanPedro as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $sanPedro->id
            ]);
        }

        // Communes pour Korhogo
        $communesKorhogo = [
            'Korhogo Centre',
            'Ferkessédougou',
            'Boundiali'
        ];

        $korhogo = Ville::where('name', 'Korhogo')->first();
        foreach ($communesKorhogo as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $korhogo->id
            ]);
        }

        // Communes pour Man
        $communesMan = [
            'Man Centre',
            'Danané',
            'Biankouma'
        ];

        $man = Ville::where('name', 'Man')->first();
        foreach ($communesMan as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $man->id
            ]);
        }

        // Communes pour Gagnoa
        $communesGagnoa = [
            'Gagnoa Centre',
            'Oumé',
            'Vavoua'
        ];

        $gagnoa = Ville::where('name', 'Gagnoa')->first();
        foreach ($communesGagnoa as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $gagnoa->id
            ]);
        }

        // Communes pour Abengourou
        $communesAbengourou = [
            'Abengourou Centre',
            'Agnibilékrou',
            'Bettié'
        ];

        $abengourou = Ville::where('name', 'Abengourou')->first();
        foreach ($communesAbengourou as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $abengourou->id
            ]);
        }

        // Communes pour Divo
        $communesDivo = [
            'Divo Centre',
            'Lakota',
            'Tiassalé'
        ];

        $divo = Ville::where('name', 'Divo')->first();
        foreach ($communesDivo as $communeName) {
            Commune::create([
                'name' => $communeName,
                'ville_id' => $divo->id
            ]);
        }
    }
}
