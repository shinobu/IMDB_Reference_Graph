USING PERIODIC COMMIT 1000
LOAD CSV WITH HEADERS FROM "file:///movie.csv" AS csvLine
CREATE (:Movie { id: toInteger(csvLine.id),
                  title: csvLine.title,
                  date: csvLine.date});

USING PERIODIC COMMIT 1000
LOAD CSV WITH HEADERS FROM "file:///links.csv" AS csvLine
MATCH (n:Movie { id: toInteger(csvLine.mainid)}),(m:Movie { id: toInteger(csvLine.refid)})
CREATE (n)-[:Relation { type: csvLine.type }]->(m)
