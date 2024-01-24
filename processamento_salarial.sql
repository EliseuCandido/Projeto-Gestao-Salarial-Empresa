-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Ago-2023 às 00:43
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `processamento_salarial`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `departamentos`
--

INSERT INTO `departamentos` (`id`, `nome`, `descricao`) VALUES
(1, 'Sem Departamento', 'Indica que o usuário não está associado a um departamento'),
(6, 'Atec', 'Escola tecnica'),
(13, 'Pizzapalace', 'Pizzaria \r\natualmente em Lisboa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `processamento_salarios`
--

CREATE TABLE `processamento_salarios` (
  `id` int(11) NOT NULL,
  `salario_bruto` decimal(10,2) NOT NULL,
  `ano` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `dias_trabalhados` int(11) NOT NULL,
  `desconto_seguranca_social` decimal(10,2) NOT NULL,
  `desconto_irs` decimal(10,2) NOT NULL,
  `alimentacao` decimal(10,2) NOT NULL,
  `salario_liquido` decimal(10,2) NOT NULL,
  `utilizador_id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `processamento_salarios`
--

INSERT INTO `processamento_salarios` (`id`, `salario_bruto`, `ano`, `mes`, `dias_trabalhados`, `desconto_seguranca_social`, `desconto_irs`, `alimentacao`, `salario_liquido`, `utilizador_id`, `departamento_id`) VALUES
(10, 2000.00, 2023, 1, 22, 220.00, 320.00, 115.50, 1575.50, 95, 6),
(11, 2100.00, 2023, 2, 20, 231.00, 336.00, 105.00, 1638.00, 95, 6),
(12, 8000.00, 2023, 7, 21, 880.00, 1280.00, 110.25, 5950.25, 95, 6),
(13, 5400.00, 2023, 2, 20, 594.00, 864.00, 105.00, 4047.00, 119, 6),
(14, 5130.00, 2023, 3, 23, 564.30, 820.80, 120.75, 3865.65, 119, 6),
(15, 5150.00, 2023, 4, 20, 566.50, 824.00, 105.00, 3864.50, 119, 6),
(16, 5632.00, 2023, 6, 22, 619.52, 901.12, 115.50, 4226.86, 119, 6),
(17, 6340.00, 2023, 7, 21, 697.40, 1014.40, 110.25, 4738.45, 119, 6),
(18, 530.00, 2023, 1, 22, 58.30, 47.70, 115.50, 539.50, 121, 13),
(19, 250.00, 2023, 2, 20, 27.50, 22.50, 105.00, 305.00, 121, 13),
(20, 148.00, 2023, 3, 23, 16.28, 13.32, 120.75, 239.15, 121, 13),
(21, 78.00, 2023, 4, 20, 8.58, 7.02, 105.00, 167.40, 121, 13),
(22, 6000.00, 2022, 12, 22, 660.00, 960.00, 115.50, 4495.50, 95, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_senha` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'user',
  `user_nome` varchar(255) DEFAULT NULL,
  `user_nif` int(11) DEFAULT NULL,
  `user_iban` varchar(34) DEFAULT NULL,
  `user_telm` varchar(20) DEFAULT NULL,
  `user_tel` varchar(20) DEFAULT NULL,
  `user_morada` varchar(255) DEFAULT NULL,
  `user_localidade` varchar(255) DEFAULT NULL,
  `user_cp` varchar(20) DEFAULT NULL,
  `user_departamento` int(11) DEFAULT NULL,
  `user_funcao` varchar(255) DEFAULT NULL,
  `user_estado` varchar(50) DEFAULT 'ativo',
  `user_data_nasc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_senha`, `user_type`, `user_nome`, `user_nif`, `user_iban`, `user_telm`, `user_tel`, `user_morada`, `user_localidade`, `user_cp`, `user_departamento`, `user_funcao`, `user_estado`, `user_data_nasc`) VALUES
(1, 'admin@gmail.com', '1234', 'admin', '', 0, '', '', '', '', '', '', 1, '', 'ativo', '0000-00-00'),
(95, 'eliseucandido@gmail.com', '1234', 'user', 'Eliseu', 232323272, 'PT50 4882 1323 1334 3678 2344 5', '932147865', '212348765', 'Rua dos Parque, 233', 'Setubal', '2930-039', 6, 'Formando', 'ativo', '2000-09-17'),
(119, 'hugo.farinha@edu.atec.pt', '1234', 'user', 'Hugo Farinha', 287654321, 'PT50 0002 0123 1234 5678 9015 4', '912345678', '212345678', 'Rua das Flores, 123', 'Lisboa', '1000-123', 6, 'Formador', 'ativo', '9333-02-10'),
(121, 'maria@gmail.com', '1234', 'user', 'Maria Santos', 285457325, 'PT50 0002 0123 1234 5678 9015 5', '932147865', '212348765', 'Av. da Liberdade, 456', 'Lisboa', '13231-312', 13, 'Pizzaiolo', 'ativo', '2002-01-19');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `processamento_salarios`
--
ALTER TABLE `processamento_salarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilizador_id` (`utilizador_id`),
  ADD KEY `departamento_id` (`departamento_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_departamento` (`user_departamento`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `processamento_salarios`
--
ALTER TABLE `processamento_salarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `processamento_salarios`
--
ALTER TABLE `processamento_salarios`
  ADD CONSTRAINT `processamento_salarios_ibfk_1` FOREIGN KEY (`utilizador_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `processamento_salarios_ibfk_2` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_departamento`) REFERENCES `departamentos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
