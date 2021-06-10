ALTER TABLE questao ALTER column pergunta DROP NOT NULL;
ALTER TABLE questao ALTER column pergunta DROP NOT NULL;
ALTER TABLE questao ALTER column is_multipla_escolha DROP NOT NULL;
ALTER TABLE questao ALTER column prova_id DROP NOT NULL;
ALTER TABLE questao ALTER column minutos_realizacao DROP NOT NULL;
ALTER TABLE questao ALTER column peso DROP NOT NULL;
ALTER TABLE questao ALTER column is_obrigatoria DROP NOT NULL;


ALTER TABLE prova ALTER column inicio DROP NOT NULL;
ALTER TABLE prova ALTER column fim DROP NOT NULL;


ALTER TABLE prova ADD column is_ordenada BOOLEAN DEFAULT true;
ALTER TABLE prova ADD column is_formulario_livre BOOLEAN DEFAULT true;
ALTER TABLE prova ADD column descricao TEXT;
ALTER TABLE prova DROP column sucinto;

ALTER TABLE questao ALTER COLUMN is_multipla_escolha DROP DEFAULT