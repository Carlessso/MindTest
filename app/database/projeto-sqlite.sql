PRAGMA foreign_keys=OFF; 

CREATE TABLE alternativa( 
      id  INTEGER    NOT NULL  , 
      questao_id int   NOT NULL  , 
      descricao text   NOT NULL  , 
      is_correta text   NOT NULL    DEFAULT 'F', 
 PRIMARY KEY (id),
FOREIGN KEY(questao_id) REFERENCES questao(id)) ; 

CREATE TABLE alternativa_resposta_questao( 
      id  INTEGER    NOT NULL  , 
      alternativa_id int   NOT NULL  , 
      questao_usuario_prova_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(alternativa_id) REFERENCES alternativa(id),
FOREIGN KEY(questao_usuario_prova_id) REFERENCES questao_usuario_prova(id)) ; 

CREATE TABLE grupo( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      descricao text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_prova( 
      id  INTEGER    NOT NULL  , 
      prova_id int   NOT NULL  , 
      grupo_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(prova_id) REFERENCES prova(id),
FOREIGN KEY(grupo_id) REFERENCES grupo(id)) ; 

CREATE TABLE grupo_usuario( 
      id  INTEGER    NOT NULL  , 
      usuario_id int   NOT NULL  , 
      grupo_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(usuario_id) REFERENCES usuario(id),
FOREIGN KEY(grupo_id) REFERENCES grupo(id)) ; 

CREATE TABLE prova( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      sucinto text   NOT NULL  , 
      minutos_realizacao int   , 
      cor_primaria text   NOT NULL  , 
      cor_secundaria text   NOT NULL  , 
      usuario_responsavel int   NOT NULL  , 
      is_publica text   NOT NULL    DEFAULT 'F', 
      inicio datetime   NOT NULL  , 
      fim datetime   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(usuario_responsavel) REFERENCES usuario(id)) ; 

CREATE TABLE questao( 
      id  INTEGER    NOT NULL  , 
      pergunta text   NOT NULL  , 
      is_multipla_escolha text   NOT NULL    DEFAULT 'T', 
      prova_id int   NOT NULL  , 
      minutos_realizacao int   , 
      peso double  (10,3)   NOT NULL  , 
      is_obrigatoria text   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id),
FOREIGN KEY(prova_id) REFERENCES prova(id)) ; 

CREATE TABLE questao_usuario_prova( 
      id  INTEGER    NOT NULL  , 
      questao_id int   NOT NULL  , 
      usuario_prova_id int   NOT NULL  , 
      resposta_usuario text   , 
      peso double  (10,3)   NOT NULL  , 
      dt_registro datetime   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(questao_id) REFERENCES questao(id),
FOREIGN KEY(usuario_prova_id) REFERENCES usuario_prova(id)) ; 

CREATE TABLE resposta( 
      id  INTEGER    NOT NULL  , 
      questao_id int   NOT NULL  , 
      resposta text   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(questao_id) REFERENCES questao(id)) ; 

CREATE TABLE usuario( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      email text   NOT NULL  , 
      senha text   NOT NULL  , 
      is_professor text   NOT NULL    DEFAULT 'F', 
 PRIMARY KEY (id)) ; 

CREATE TABLE usuario_prova( 
      id  INTEGER    NOT NULL  , 
      usuario_id int   NOT NULL  , 
      prova_id int   NOT NULL  , 
      inicio datetime   NOT NULL  , 
      fim datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(usuario_id) REFERENCES usuario(id),
FOREIGN KEY(prova_id) REFERENCES prova(id)) ; 

 
 
  
