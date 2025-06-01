CREATE DATABASE IF NOT EXISTS pinework_DB;
USE pinework_DB;

-- Drop na ordem correta para respeitar chaves estrangeiras
DROP TABLE IF EXISTS additional_costs;
DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS budgets;

-- Tabela principal de orçamentos
CREATE TABLE IF NOT EXISTS budgets (
  id INT(11) NOT NULL AUTO_INCREMENT,
  client VARCHAR(255) NOT NULL,
  budget DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  costs DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  status ENUM('draft', 'completed', 'not_paid', 'not_done') NOT NULL DEFAULT 'draft',
  data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de películas associadas a um orçamento
CREATE TABLE IF NOT EXISTS films (
  id INT(11) NOT NULL AUTO_INCREMENT,
  budget_id INT(11) NOT NULL,
  name VARCHAR(100) NOT NULL,
  width DECIMAL(10,2) NOT NULL,
  height DECIMAL(10,2) NOT NULL,
  cost DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_films_budget
    FOREIGN KEY (budget_id) REFERENCES budgets(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de custos adicionais
CREATE TABLE IF NOT EXISTS additional_costs (
  id INT(11) NOT NULL AUTO_INCREMENT,
  budget_id INT(11) NOT NULL,
  worked_hours DECIMAL(10,2) NOT NULL,
  distance_km DECIMAL(10,2) NOT NULL,
  travel_cost DECIMAL(10,2) AS (distance_km * 1.10) STORED,
  collaborators INT NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_additional_costs_budget
    FOREIGN KEY (budget_id) REFERENCES budgets(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
