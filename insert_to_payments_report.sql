SELECT
    CONCAT(
            'INSERT INTO payments (paid_at, value, user_type) VALUES (\'', CONCAT(t.received_at, ' 10:00:00'),
            '\', ',
            t.value, ', \'',
            IF(
                        s.min_received_at <
                        DATE_SUB(
                                t.received_at,
                                INTERVAL
                                7
                                DAY),
                        IF(
                                    (SELECT
                                        COUNT(*)
                                    FROM wp_darujme_payments AS p
                                    LEFT JOIN wp_darujme_users AS u
                                              ON p.email =
                                                 u.email
                                    WHERE IFNULL(
                                                  u.authoritative_email,
                                                  p.email) =
                                          t.email
                                      AND p.campaign =
                                          'dielo_trnavka'
                                      AND p.received_at <=
                                          DATE_SUB(
                                                  t.received_at,
                                                  INTERVAL
                                                  14
                                                  DAY)
                                      AND DATE_SUB(
                                                  t.received_at,
                                                  INTERVAL
                                                  3
                                                  MONTH) <=
                                          p.received_at
                                    GROUP BY IFNULL(
                                            u.authoritative_email,
                                            p.email)) >=
                                    1,
                                    'pravidelny',
                                    'obnoveny'),
                        'novy'), '\');')
FROM (SELECT
    p.name,
    p.surname,
    DATE(p.received_at) AS received_at,
    ROUND(p.value /
          100)          AS value,
    IFNULL(
            u.authoritative_email,
            p.email)        AS email
FROM wp_darujme_payments AS p
LEFT JOIN wp_darujme_users AS u
          ON p.email =
             u.email
WHERE p.campaign =
      'dielo_trnavka') AS t
LEFT JOIN (SELECT
    MIN(DATE(p.received_at)) AS min_received_at,
    IFNULL(
            u.authoritative_email,
            p.email)             AS email
FROM wp_darujme_payments AS p
LEFT JOIN wp_darujme_users AS u
          ON p.email =
             u.email
GROUP BY email) AS s
          ON t.email =
             s.email
ORDER BY
    t.received_at
