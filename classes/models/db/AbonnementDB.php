<?php

namespace models\db;

class AbonnementDB {

    public static function followUser(int $idU, int $idA): bool {
        $db = Database::getInstance();
        $query = $db->prepare("INSERT INTO abonnement (idU, idA) VALUES (:idU, :idA)");
        return $query->execute([':idU' => $idU, ':idA' => $idA]);
    }

    public static function unfollowUser(int $idU, int $idA): bool {
        $db = Database::getInstance();
        $query = $db->prepare("DELETE FROM abonnement WHERE idU = :idU AND idA = :idA");
        return $query->execute([':idU' => $idU, ':idA' => $idA]);
    }

    public static function getFollowersCount(int $idA): int {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT COUNT(*) FROM abonnement WHERE idA = :idA");
        $query->execute([':idA' => $idA]);
        return $query->fetchColumn();
    }

    public static function getUserFollowedArtists(int $idU): array {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT idA FROM abonnement WHERE idU = :idU");
        $query->execute([':idU' => $idU]);
        return $query->fetchAll();
    }

    public static function isUserFollowing(int $idU, int $idA): bool {
      $db = Database::getInstance();
      $query = $db->prepare("SELECT COUNT(*) FROM abonnement WHERE idU = :idU AND idA = :idA");
      $query->execute([':idU' => $idU, ':idA' => $idA]);
      return $query->fetchColumn() > 0;
  }
}