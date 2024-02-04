SELECT
    DATE(p.received_at) AS received_on,
    MAX(DATE(p.received_at)) AS last_received_on,
    IFNULL(u.authoritative_email, p.email) AS email1,
    IF(p.campaign IN ('ba_trnavka_dielo_trnavka', 'dielo_trnavka'), 'dielo_trnavka', p.campaign) as campaign1,
    COUNT(*)
FROM wp_darujme_payments AS p
LEFT JOIN wp_darujme_users AS u
          ON p.email =
             u.email
GROUP BY
    email1, campaign1
ORDER BY
    last_received_on DESC, email1;


SELECT
    email,
    old_email,
    campaign,
    ROUND(AVG(value) / 100) AS avg_value,
    GROUP_CONCAT(DISTINCT ROUND(value / 100)) AS `values`,
    MAX(received_on) AS last_received_on,
    GROUP_CONCAT(received_on ORDER BY received_on DESC) AS every_received_on,
    GROUP_CONCAT(DISTINCT real_campaign) as campaigns,
    ROUND(AVG(DATEDIFF(received_on, lag_received_on))) AS avg_day_diff,
    COUNT(*) AS count,
    DATE_ADD(MAX(received_on), INTERVAL AVG(DATEDIFF(received_on, lag_received_on)) * 3 DAY) AS next_due_date
FROM (
    SELECT
        p.value,
        p.email AS old_email,
        IF(p.campaign IN ('ba_trnavka_dielo_trnavka', 'dielo_trnavka'), 'dielo_trnavka', p.campaign) as campaign,
        p.campaign AS real_campaign,
        #  'x' as campaign,
        IFNULL(u.authoritative_email, p.email) AS email,
        DATE(p.received_at) AS received_on,
        DATE(LAG(p.received_at) OVER (PARTITION BY IFNULL(u.authoritative_email, p.email), IF(p.campaign IN ('ba_trnavka_dielo_trnavka', 'dielo_trnavka'), 'dielo_trnavka', p.campaign) ORDER BY p.received_at)) AS lag_received_on
    FROM wp_darujme_payments AS p
    LEFT JOIN wp_darujme_users AS u
              ON p.email =
                 u.email
) AS diff
GROUP BY
    email, campaign
HAVING
        count > 3 AND next_due_date < NOW() AND last_received_on > DATE_SUB(now(), INTERVAL 2 YEAR)
ORDER BY
    campaign, email, count DESC;


SELECT p.received_at AS received_on,
    LAG(p.received_at) OVER (ORDER BY p.received_at) AS lag_received_on
FROM wp_darujme_payments AS p
LEFT JOIN wp_darujme_users AS u
          ON p.email =
             u.email;
