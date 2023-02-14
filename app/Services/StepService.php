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
    return Step::get();
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
   * Steps der besten Läufer
   */
  public function get_steps_läufer()
  {
    $steps_läufer = Step::select(
      "vorname",
      "name",
      "klasse",
      Step::raw("SUM(schritte) AS schritte_sum"),
      Step::raw("ROW_NUMBER() OVER (ORDER BY SUM(schritte) DESC) AS ranking")
    )
      ->withCasts(["ranking" => "integer"])
      ->groupBy("vorname", "name", "klasse")
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
      "steps.klasse",
      Step::raw("SUM(schritte) AS schritte_sum"),
      "teilnehmer_anzahl",
      Step::raw("SUM(schritte)/teilnehmer_anzahl AS schritte_pro_kopf"),
      Step::raw(
        "ROW_NUMBER() OVER (ORDER BY SUM(schritte)/teilnehmer_anzahl DESC, teilnehmer_anzahl DESC) AS ranking"
      )
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
      "vorname",
      "name",
      "klasse",
      Step::raw("SUM(schritte) AS schritte_sum"),
      Step::raw("ROW_NUMBER() OVER (ORDER BY SUM(schritte) DESC) AS ranking")
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
