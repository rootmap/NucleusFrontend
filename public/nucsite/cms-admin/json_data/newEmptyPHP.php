SELECT 
c.`id` as cid,
c.`name`,
cn.id,
cn.news_headding,
cn.news_thumble,
cn.news_short_details,
cn.news_date_time,
r.name as reporter
FROM `category` as c 
INNER JOIN compose_news as cn ON cn.select_category_news=c.`id` 
INNER JOIN reporter as r ON r.id=cn.reporter
WHERE 
c.`id`='13'