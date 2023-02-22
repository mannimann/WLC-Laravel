<?php

namespace App\Services;

use App\Models\Step;
use App\Models\Zeitraum;

class StepService
{
  /*
   * Alle Daten
   */
  public function get_all()
  {
    return Step::select(
      "steps.id",
      "vorname",
      "name",
      "steps.klasse",
      "kategorie",
      "von",
      "bis",
      "schritte",
      "screenshot",
      "steps.created_at",
      "steps.updated_at"
    )
      ->join("klassen", "steps.klasse", "=", "klassen.klasse")
      ->orderBy("vorname")
      ->orderBy("name")
      ->orderByRaw("LENGTH(steps.klasse) ASC")
      ->orderBy("steps.klasse")
      ->orderBy("von")
      ->orderBy("bis")
      ->get();
  }

  /*
   * Steps gruppiert nach Zeiträumen
   */
  public function get_steps_zeitraum()
  {
    $zeiträume = Zeitraum::select("von", "bis")
      ->orderBy("von")
      ->orderBy("bis")
      ->get();

    $steps_zeitraum = [];
    foreach ($zeiträume as $z) {
      $sz = Step::select(
        Step::raw("SUM(schritte) AS schritte_sum"),
        Step::raw("COUNT(id) AS teilnehmer_count"),
        Step::raw("SUM(schritte)/COUNT(id) AS schritte_pro_kopf")
      )
        ->where("von", "=", $z->von)
        ->where("bis", "=", $z->bis)
        ->get();

      $zd =
        date_format(date_create($z->von), "d.m.") .
        " - " .
        date_format(date_create($z->bis), "d.m.y");
      $steps_zeitraum[] = [
        "zeitraum" => $zd,
        "schritte_sum" => $sz[0]->schritte_sum > 0 ? $sz[0]->schritte_sum : 0,
        "teilnehmer_count" =>
          $sz[0]->teilnehmer_count > 0 ? $sz[0]->teilnehmer_count : 0,
        "schritte_pro_kopf" =>
          $sz[0]->schritte_pro_kopf > 0 ? $sz[0]->schritte_pro_kopf : 0,
      ];
    }

    // Footer bzw. Zeile Gesamt
    if (count($steps_zeitraum) > 0) {
      $zeitraum_sub = Step::select(
        Step::raw("COUNT(*) AS 'teilnehmer_count'")
      )->fromSub(function ($query) {
        $query->from("steps")->groupBy("vorname", "name", "klasse");
      }, "s");

      $zeitraum_gesamt = Step::select(
        Step::raw("SUM(schritte) AS schritte_sum"),
        Step::raw("teilnehmer_count"),
        Step::raw("SUM(schritte)/COUNT(id) AS schritte_pro_kopf")
      )
        ->joinSub($zeitraum_sub, "steps2", Step::raw(1), "=", Step::raw(1))
        ->get();

      $steps_zeitraum[] = [
        "zeitraum" => "Gesamt",
        "schritte_sum" =>
          $zeitraum_gesamt[0]->schritte_sum > 0
            ? $zeitraum_gesamt[0]->schritte_sum
            : 0,
        "teilnehmer_count" =>
          $zeitraum_gesamt[0]->teilnehmer_count > 0
            ? $zeitraum_gesamt[0]->teilnehmer_count
            : 0,
        "schritte_pro_kopf" =>
          $zeitraum_gesamt[0]->schritte_pro_kopf > 0
            ? $zeitraum_gesamt[0]->schritte_pro_kopf
            : 0,
      ];
    }

    return $steps_zeitraum;
  }

  /*
   * Steps der besten Schüler
   */
  public function get_steps_läufer_schüler()
  {
    $steps_läufer = Step::select(
      Step::raw("ROW_NUMBER() OVER (ORDER BY SUM(schritte) DESC) AS ranking"),
      "vorname",
      "name",
      "steps.klasse",
      Step::raw("SUM(schritte) AS schritte_sum")
    )
      ->join("klassen", "steps.klasse", "=", "klassen.klasse")
      ->where("kategorie", "=", "Schüler")
      ->withCasts(["ranking" => "integer"])
      ->groupBy("vorname", "name", "steps.klasse")
      ->orderByDesc("schritte_sum")
      ->get();

    return $steps_läufer;
  }

  /*
   * Steps der besten Erwachsenen
   */
  public function get_steps_läufer_erwachsene()
  {
    $steps_läufer = Step::select(
      Step::raw("ROW_NUMBER() OVER (ORDER BY SUM(schritte) DESC) AS ranking"),
      "vorname",
      "name",
      "steps.klasse",
      Step::raw("SUM(schritte) AS schritte_sum")
    )
      ->join("klassen", "steps.klasse", "=", "klassen.klasse")
      ->where("kategorie", "=", "Erwachsene")
      ->withCasts(["ranking" => "integer"])
      ->groupBy("vorname", "name", "steps.klasse")
      ->orderByDesc("schritte_sum")
      ->get();

    return $steps_läufer;
  }

  /*
   * Steps gruppiert nach Klassen
   */
  public function get_steps_klassen()
  {
    $klassen_sub = Step::select(
      "s.klasse",
      Step::raw("COUNT(*) AS 'teilnehmer_anzahl'")
    )
      ->fromSub(function ($query) {
        $query->from("steps")->groupBy("vorname", "name", "klasse");
      }, "s")
      ->groupBy("s.klasse");

    $steps_klassen = Step::select(
      Step::raw(
        "ROW_NUMBER() OVER (ORDER BY SUM(schritte)/teilnehmer_anzahl DESC, teilnehmer_anzahl DESC) AS ranking"
      ),
      "steps.klasse",
      Step::raw("SUM(schritte) AS schritte_sum"),
      Step::raw("SUM(schritte)/teilnehmer_anzahl AS schritte_pro_kopf"),
      "teilnehmer_anzahl"
    )
      ->joinSub($klassen_sub, "steps2", "steps.klasse", "=", "steps2.klasse")
      ->withCasts(["ranking" => "integer"])
      ->groupBy("steps.klasse")
      ->having("teilnehmer_anzahl", ">", 0)
      ->orderByDesc("schritte_pro_kopf")
      ->orderByDesc("teilnehmer_anzahl")
      ->get();

    return $steps_klassen;
  }

  /*
   * Steps gruppiert nach Läufer (Alle Läufer)
   */
  public function get_steps_läufer_zeitraum()
  {
    $zeiträume = Zeitraum::select("von", "bis")
      ->orderBy("von")
      ->orderBy("bis")
      ->get();

    $steps_sub = [];
    $i = 0;
    foreach ($zeiträume as $zeitraum) {
      $i++;
      $steps_sub[] = Step::from("steps AS zeitraum" . $i)
        ->select("zeitraum" . $i . ".schritte")
        ->whereColumn("zeitraum" . $i . ".vorname", "ges.vorname")
        ->whereColumn("zeitraum" . $i . ".name", "ges.name")
        ->whereColumn("zeitraum" . $i . ".klasse", "ges.klasse")
        ->where("zeitraum" . $i . ".von", $zeitraum["von"])
        ->where("zeitraum" . $i . ".bis", $zeitraum["bis"])
        ->limit(1)
        ->getQuery();
    }

    $steps_läufer_zeitraum = Step::from("steps As ges")->select(
      Step::raw("ROW_NUMBER() OVER (ORDER BY SUM(schritte) DESC) AS ranking"),
      "vorname",
      "name",
      "klasse",
      Step::raw("SUM(schritte) AS schritte_sum")
    );

    $i = 0;
    foreach ($steps_sub as $zeitraum_sub) {
      $i++;
      $steps_läufer_zeitraum = $steps_läufer_zeitraum->selectSub(
        $zeitraum_sub,
        "zeitraum" . $i
      );
    }

    $steps_läufer_zeitraum = $steps_läufer_zeitraum
      ->withCasts(["ranking" => "integer"])
      ->groupBy("ges.vorname", "ges.name", "ges.klasse")
      ->orderByDesc("schritte_sum")
      ->get();

    return $steps_läufer_zeitraum;
  }
}
