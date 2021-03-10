CREATE TABLE alternativa( 
      id  INT IDENTITY    NOT NULL  , 
      questao_id int   NOT NULL  , 
      descricao nvarchar(max)   NOT NULL  , 
      is_correta bit   NOT NULL    DEFAULT false, 
 PRIMARY KEY (id)) ; 

CREATE TABLE alternativa_resposta_questao( 
      id  INT IDENTITY    NOT NULL  , 
      alternativa_id int   NOT NULL  , 
      questao_usuario_prova_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      descricao nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_prova( 
      id  INT IDENTITY    NOT NULL  , 
      prova_id int   NOT NULL  , 
      grupo_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_usuario( 
      id  INT IDENTITY    NOT NULL  , 
      usuario_id int   NOT NULL  , 
      grupo_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prova( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      sucinto nvarchar(max)   NOT NULL  , 
      minutos_realizacao int   , 
      cor_primaria nvarchar(max)   NOT NULL  , 
      cor_secundaria nvarchar(max)   NOT NULL  , 
      usuario_responsavel int   NOT NULL  , 
      is_publica bit   NOT NULL    DEFAULT false, 
      inicio datetime2   NOT NULL    DEFAULT now(), 
      fim datetime2   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE questao( 
      id  INT IDENTITY    NOT NULL  , 
      pergunta nvarchar(max)   NOT NULL  , 
      is_multipla_escolha bit   NOT NULL    DEFAULT true, 
      prova_id int   NOT NULL  , 
      minutos_realizacao int   , 
      peso float  (10,3)   NOT NULL  , 
      is_obrigatoria bit   NOT NULL    DEFAULT true, 
 PRIMARY KEY (id)) ; 

CREATE TABLE questao_usuario_prova( 
      id  INT IDENTITY    NOT NULL  , 
      questao_id int   NOT NULL  , 
      usuario_prova_id int   NOT NULL  , 
      resposta_usuario nvarchar(max)   , 
      peso float  (10,3)   NOT NULL  , 
      dt_registro datetime2   NOT NULL    DEFAULT now(), 
 PRIMARY KEY (id)) ; 

CREATE TABLE resposta( 
      id  INT IDENTITY    NOT NULL  , 
      questao_id int   NOT NULL  , 
      resposta nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE usuario( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      email nvarchar(max)   NOT NULL  , 
      senha nvarchar(max)   NOT NULL  , 
      is_professor bit   NOT NULL    DEFAULT false, 
 PRIMARY KEY (id)) ; 

CREATE TABLE usuario_prova( 
      id  INT IDENTITY    NOT NULL  , 
      usuario_id int   NOT NULL  , 
      prova_id int   NOT NULL  , 
      inicio datetime2   NOT NULL    DEFAULT now(), 
      fim datetime2   , 
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

  
