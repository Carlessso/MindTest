CREATE TABLE alternativa( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      questao_id int   NOT NULL  , 
      descricao text   NOT NULL  , 
      is_correta boolean   NOT NULL    DEFAULT false, 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE alternativa_resposta_questao( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      alternativa_id int   NOT NULL  , 
      questao_usuario_prova_id int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE grupo( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      nome text   NOT NULL  , 
      descricao text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE grupo_prova( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      prova_id int   NOT NULL  , 
      grupo_id int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE grupo_usuario( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      usuario_id int   NOT NULL  , 
      grupo_id int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE prova( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      nome text   NOT NULL  , 
      sucinto text   NOT NULL  , 
      minutos_realizacao int   , 
      cor_primaria text   NOT NULL  , 
      cor_secundaria text   NOT NULL  , 
      usuario_responsavel int   NOT NULL  , 
      is_publica boolean   NOT NULL    DEFAULT false, 
      inicio datetime   NOT NULL    DEFAULT now(), 
      fim datetime   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE questao( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      pergunta text   NOT NULL  , 
      is_multipla_escolha boolean   NOT NULL    DEFAULT true, 
      prova_id int   NOT NULL  , 
      minutos_realizacao int   , 
      peso double   NOT NULL  , 
      is_obrigatoria boolean   NOT NULL    DEFAULT true, 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE questao_usuario_prova( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      questao_id int   NOT NULL  , 
      usuario_prova_id int   NOT NULL  , 
      resposta_usuario text   , 
      peso double   NOT NULL  , 
      dt_registro datetime   NOT NULL    DEFAULT now(), 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE resposta( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      questao_id int   NOT NULL  , 
      resposta text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE usuario( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      nome text   NOT NULL  , 
      email text   NOT NULL  , 
      senha text   NOT NULL  , 
      is_professor boolean   NOT NULL    DEFAULT false, 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE usuario_prova( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      usuario_id int   NOT NULL  , 
      prova_id int   NOT NULL  , 
      inicio datetime   NOT NULL    DEFAULT now(), 
      fim datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
  
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

  
