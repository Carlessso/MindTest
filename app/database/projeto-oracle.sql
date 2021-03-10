CREATE TABLE alternativa( 
      id number(10)    NOT NULL , 
      questao_id number(10)    NOT NULL , 
      descricao varchar(10000)    NOT NULL , 
      is_correta char(1)    DEFAULT false  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE alternativa_resposta_questao( 
      id number(10)    NOT NULL , 
      alternativa_id number(10)    NOT NULL , 
      questao_usuario_prova_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo( 
      id number(10)    NOT NULL , 
      nome varchar(10000)    NOT NULL , 
      descricao varchar(10000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_prova( 
      id number(10)    NOT NULL , 
      prova_id number(10)    NOT NULL , 
      grupo_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_usuario( 
      id number(10)    NOT NULL , 
      usuario_id number(10)    NOT NULL , 
      grupo_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prova( 
      id number(10)    NOT NULL , 
      nome varchar(10000)    NOT NULL , 
      sucinto varchar(10000)    NOT NULL , 
      minutos_realizacao number(10)   , 
      cor_primaria varchar(10000)    NOT NULL , 
      cor_secundaria varchar(10000)    NOT NULL , 
      usuario_responsavel number(10)    NOT NULL , 
      is_publica char(1)    DEFAULT false  NOT NULL , 
      inicio timestamp(0)    DEFAULT now()  NOT NULL , 
      fim timestamp(0)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE questao( 
      id number(10)    NOT NULL , 
      pergunta varchar(10000)    NOT NULL , 
      is_multipla_escolha char(1)    DEFAULT true  NOT NULL , 
      prova_id number(10)    NOT NULL , 
      minutos_realizacao number(10)   , 
      peso binary_double  (10,3)    NOT NULL , 
      is_obrigatoria char(1)    DEFAULT true  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE questao_usuario_prova( 
      id number(10)    NOT NULL , 
      questao_id number(10)    NOT NULL , 
      usuario_prova_id number(10)    NOT NULL , 
      resposta_usuario varchar(10000)   , 
      peso binary_double  (10,3)    NOT NULL , 
      dt_registro timestamp(0)    DEFAULT now()  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE resposta( 
      id number(10)    NOT NULL , 
      questao_id number(10)    NOT NULL , 
      resposta varchar(10000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE usuario( 
      id number(10)    NOT NULL , 
      nome varchar(10000)    NOT NULL , 
      email varchar(10000)    NOT NULL , 
      senha varchar(10000)    NOT NULL , 
      is_professor char(1)    DEFAULT false  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE usuario_prova( 
      id number(10)    NOT NULL , 
      usuario_id number(10)    NOT NULL , 
      prova_id number(10)    NOT NULL , 
      inicio timestamp(0)    DEFAULT now()  NOT NULL , 
      fim timestamp(0)   , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE alternativa ADD CONSTRAINT fk_alternativa_1 FOREIGN KEY (questao_id) references questao(id); 
ALTER TABLE alternativa_resposta_questao ADD CONSTRAINT fk_alternativa_resposta_questao_1 FOREIGN KEY (alternativa_id) references alternativa(id); 
ALTER TABLE alternativa_resposta_questao ADD CONSTRAINT fk_alternativa_resposta_questao_2 FOREIGN KEY (questao_usuario_prova_id) references questao_usuario_prova(id); 
ALTER TABLE grupo_prova ADD CONSTRAINT fk_grupo_prova_1 FOREIGN KEY (prova_id) references prova(id); 
ALTER TABLE grupo_prova ADD CONSTRAINT fk_grupo_prova_2 FOREIGN KEY (grupo_id) references grupo(id); 
ALTER TABLE grupo_usuario ADD CONSTRAINT fk_grupo_usuario_1 FOREIGN KEY (usuario_id) references usuario(id); 
ALTER TABLE grupo_usuario ADD CONSTRAINT fk_grupo_usuario_2 FOREIGN KEY (grupo_id) references grupo(id); 
ALTER TABLE prova ADD CONSTRAINT fk_prova_1 FOREIGN KEY (usuario_responsavel) references usuario(id); 
ALTER TABLE questao ADD CONSTRAINT fk_questao_1 FOREIGN KEY (prova_id) references prova(id); 
ALTER TABLE questao_usuario_prova ADD CONSTRAINT fk_questao_usuario_prova_1 FOREIGN KEY (questao_id) references questao(id); 
ALTER TABLE questao_usuario_prova ADD CONSTRAINT fk_questao_usuario_prova_2 FOREIGN KEY (usuario_prova_id) references usuario_prova(id); 
ALTER TABLE resposta ADD CONSTRAINT fk_resposta_1 FOREIGN KEY (questao_id) references questao(id); 
ALTER TABLE usuario_prova ADD CONSTRAINT fk_usuario_prova_1 FOREIGN KEY (usuario_id) references usuario(id); 
ALTER TABLE usuario_prova ADD CONSTRAINT fk_usuario_prova_2 FOREIGN KEY (prova_id) references prova(id); 
 CREATE SEQUENCE alternativa_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER alternativa_id_seq_tr 

BEFORE INSERT ON alternativa FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT alternativa_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE alternativa_resposta_questao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER alternativa_resposta_questao_id_seq_tr 

BEFORE INSERT ON alternativa_resposta_questao FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT alternativa_resposta_questao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE grupo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER grupo_id_seq_tr 

BEFORE INSERT ON grupo FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT grupo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE grupo_prova_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER grupo_prova_id_seq_tr 

BEFORE INSERT ON grupo_prova FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT grupo_prova_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE grupo_usuario_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER grupo_usuario_id_seq_tr 

BEFORE INSERT ON grupo_usuario FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT grupo_usuario_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE prova_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER prova_id_seq_tr 

BEFORE INSERT ON prova FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT prova_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE questao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER questao_id_seq_tr 

BEFORE INSERT ON questao FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT questao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE questao_usuario_prova_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER questao_usuario_prova_id_seq_tr 

BEFORE INSERT ON questao_usuario_prova FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT questao_usuario_prova_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE resposta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER resposta_id_seq_tr 

BEFORE INSERT ON resposta FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT resposta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE usuario_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER usuario_id_seq_tr 

BEFORE INSERT ON usuario FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT usuario_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE usuario_prova_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER usuario_prova_id_seq_tr 

BEFORE INSERT ON usuario_prova FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT usuario_prova_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
  
