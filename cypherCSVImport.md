Perequesites: 

* (probably) Neo4j Version 3.2+
* At least 3gb RAM/HEAP for the Server

Use the cypher shell:

LOAD CSV WITH HEADERS FROM "file:///movie.csv" AS csvLine
CREATE (:Movie { id: toInteger(csvLine.id),
                  title: csvLine.title,
                  date: csvLine.date});

CREATE INDEX ON :Movie(id);

LOAD CSV WITH HEADERS FROM "file:///links.csv" AS csvLine
MATCH (n:Movie { id: toInteger(csvLine.mainid)}),(m:Movie { id: toInteger(csvLine.refid)})
CREATE (n)-[:Relation { type: csvLine.type }]->(m);

DROP INDEX ON :Movie(id);
MATCH (n:Movie) REMOVE n.id;

CREATE INDEX ON :Movie(title);
CREATE INDEX ON :Movie(date);
CREATE INDEX ON :Relation(type);

