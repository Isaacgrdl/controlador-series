<?php

namespace App\Services;

use App\Serie;
use App\Temporada;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $ep_por_temporada): Serie
    {
        DB::beginTransaction();
        $serie = Serie::create(['nome' => $nomeSerie]);
        $this->criaTemporadas($qtdTemporadas, $ep_por_temporada, $serie);
        DB::commit();

        return $serie;
    }

    public function criaTemporadas(int $qtdTemporadas, int $ep_por_temporada, Serie $serie): void
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++){
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            $this->criaEpisodios($ep_por_temporada, $temporada);
        }
    }

    public function criaEpisodios(int $ep_por_temporada, Temporada $temporada): void
    {
        for($j = 1; $j <= $ep_por_temporada; $j++){
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}