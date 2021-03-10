CREATE TABLE alternativa( 
      id  SERIAL    NOT NULL  , 
      questao_id integer   NOT NULL  , 
      descricao text   NOT NULL  , 
      is_correta boolean   NOT NULL    DEFAULT false, 
 PRIMARY KEY (id)) ; 

CREATE TABLE alternativa_resposta_questao( 
      id  SERIAL    NOT NULL  , 
      alternativa_id integer   NOT NULL  , 
      questao_usuario_prova_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      descricao text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_prova( 
      id  SERIAL    NOT NULL  , 
      prova_id integer   NOT NULL  , 
      grupo_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_usuario( 
      id  SERIAL    NOT NULL  , 
      usuario_id integer   NOT NULL  , 
      grupo_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prova( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      sucinto text   NOT NULL  , 
      minutos_realizacao integer   , 
      cor_primaria text   NOT NULL  , 
      cor_secundaria text   NOT NULL  , 
      usuario_responsavel integer   NOT NULL  , 
      is_publica boolean   NOT NULL    DEFAULT false, 
      inicio timestamp   NOT NULL    DEFAULT now(), 
      fim timestamp   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE questao( 
      id  SERIAL    NOT NULL  , 
      pergunta text   NOT NULL  , 
      is_multipla_escolha boolean   NOT NULL    DEFAULT true, 
      prova_id integer   NOT NULL  , 
      minutos_realizacao integer   , 
      peso float   NOT NULL  , 
      is_obrigatoria boolean   NOT NULL    DEFAULT true, 
 PRIMARY KEY (id)) ; 

CREATE TABLE questao_usuario_prova( 
      id  SERIAL    NOT NULL  , 
      questao_id integer   NOT NULL  , 
      usuario_prova_id integer   NOT NULL  , 
      resposta_usuario text   , 
      peso float   NOT NULL  , 
      dt_registro timestamp   NOT NULL    DEFAULT now(), 
 PRIMARY KEY (id)) ; 

CREATE TABLE resposta( 
      id  SERIAL    NOT NULL  , 
      questao_id integer   NOT NULL  , 
      resposta text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE usuario( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      email text   NOT NULL  , 
      senha text   NOT NULL  , 
      is_professor boolean   NOT NULL    DEFAULT false, 
 PRIMARY KEY (id)) ; 

CREATE TABLE usuario_prova( 
      id  SERIAL    NOT NULL  , 
      usuario_id integer   NOT NULL  , 
      prova_id integer   NOT NULL  , 
      inicio timestamp   NOT NULL    DEFAULT now(), 
      fim timestamp   , 
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

  
