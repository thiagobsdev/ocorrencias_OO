-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/09/2024 às 21:10
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dpwocorrencias`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `ativos`
--

CREATE TABLE `ativos` (
  `id` int(11) NOT NULL,
  `tipo_ativo` varchar(100) NOT NULL,
  `id_ativo` varchar(100) NOT NULL,
  `id_ocorrencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `ativos`
--

INSERT INTO `ativos` (`id`, `tipo_ativo`, `id_ativo`, `id_ocorrencia`) VALUES
(107, 'RTG', '21', 204),
(108, 'RTG', '999', 204);

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `texto` text NOT NULL,
  `id_ocorrencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_comentario` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `envolvidos`
--

CREATE TABLE `envolvidos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo_de_documento` varchar(100) NOT NULL,
  `numero_documento` varchar(100) NOT NULL,
  `envolvimento` varchar(100) NOT NULL,
  `vinculo` varchar(300) NOT NULL,
  `tipo_veiculo` varchar(100) NOT NULL,
  `placa` varchar(12) NOT NULL,
  `id_ocorrencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `envolvidos`
--

INSERT INTO `envolvidos` (`id`, `nome`, `tipo_de_documento`, `numero_documento`, `envolvimento`, `vinculo`, `tipo_veiculo`, `placa`, `id_ocorrencia`) VALUES
(163, 'Thiago Barbosa dos Santos ', 'RG', '123', 'Causador', 'Integrante', '', '', 204),
(164, 'Thiago Barbosa dos Santos ', 'CPF', '123', 'Testemunha', 'Autoridade', 'Moto', 'HJA-7B01', 204);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fotos`
--

CREATE TABLE `fotos` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) NOT NULL,
  `url` varchar(220) NOT NULL,
  `id_ocorrencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `fotos`
--

INSERT INTO `fotos` (`id`, `nome`, `url`, `id_ocorrencia`, `id_usuario`) VALUES
(149, '1 - Copia.jpg', 'fotos_ocorrencias/2024-09-15/1 - Copia.jpg', 204, 26),
(150, '2.jpg', 'fotos_ocorrencias/2024-09-15/2.jpg', 204, 26);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ocorrenciaenvolvidos`
--

CREATE TABLE `ocorrenciaenvolvidos` (
  `id` int(11) NOT NULL,
  `id_ocorrencia` int(11) NOT NULL,
  `id_envolvido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `ocorrenciaenvolvidos`
--

INSERT INTO `ocorrenciaenvolvidos` (`id`, `id_ocorrencia`, `id_envolvido`) VALUES
(12, 168, 111);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ocorrencias`
--

CREATE TABLE `ocorrencias` (
  `id` int(11) NOT NULL,
  `equipe` varchar(100) NOT NULL,
  `forma_conhecimento` varchar(100) NOT NULL,
  `data_ocorrencia` date NOT NULL,
  `hora_ocorrencia` time NOT NULL,
  `titulo` varchar(300) NOT NULL,
  `area` varchar(100) NOT NULL,
  `local` varchar(100) NOT NULL,
  `tipo_natureza` varchar(100) NOT NULL,
  `natureza` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `acoes` text NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `ocorrencias`
--

INSERT INTO `ocorrencias` (`id`, `equipe`, `forma_conhecimento`, `data_ocorrencia`, `hora_ocorrencia`, `titulo`, `area`, `local`, `tipo_natureza`, `natureza`, `descricao`, `acoes`, `id_usuario`, `criado_em`) VALUES
(204, 'Dragão', 'Denúncia', '2024-09-15', '13:25:00', 'Teste de inserção com lista de envolvidos', 'Área 1', 'Bolsão', 'Avarias / Perdas dos ativos de terceiros', 'Dano', 'Teste de inserção de ocorrencia', 'Teste de inserção de ocorrencia', 26, '2024-09-15 16:26:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nivel` varchar(100) NOT NULL,
  `token` varchar(300) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel`, `token`, `status`) VALUES
(8, 'Jose Renato Tabarin Souto', 'jose.souto@dpworld.com', '$2y$10$9mNdnMNweCyCl0nyu/TTaOKLTwrX6ySyflCSH9BrwsB.YfWzlPrLy', 'Administrador', '293bca655c9a6794627255fdae4a0d1d', 'Ativo'),
(9, 'Cezar Augusto Garcia Pires de Almeida', 'cezar.almeida@dpworld.com', '$2y$10$gXrkEFMQiErJHHT4QSlL1.01vyMvV2djbHKvXz8n99fBQZaQBOP/2', 'Administrador', '', 'Ativo'),
(11, 'Flavio de Lima Monteiro Batista', 'flavio.batista@dpworld.com', '$2y$10$iv7qRlwHzWEYbk7uJNpWDeexQs.JtYhd2K0ZU5Rc/Lx0tB2AjkWMe', 'Usuário', '89f8d99dc038ad237a8524dc72eb88f1', 'Ativo'),
(12, 'Hilda Silva Souza', 'hilda.souza@dpworld.com', '$2y$10$OIvFPPcxd1sMBSEDIRx9g.eKVLrIavegE2HwW.JISdv4lZ4ikpCGW', 'Usuário', '', 'Ativo'),
(13, 'Rederson Correia Costa', 'rederson.costa@dpworld.com', '$2y$10$eSuVnMm5d0jsnbgqusJJre49I1FOxYEyoqSNcfZCw.u3oeIC9LT0q', 'Usuário', '', 'Ativo'),
(14, 'Renata Alves de Matos Santos', 'renata.matos@dpworld.com', '$2y$10$4aCwjx9gCg4CKrG1uNmOsOm/pAk6qxO22.wYEisDzKj0YGx0mtsD2', 'Usuário', '', 'Ativo'),
(15, 'Sidney Severiano de Oliveira', 'sidney.severiano@dpworld.com', '$2y$10$H4MnLBQE4NN6oSvGtlCKjeRcK5shdDfIUYBLyZSX.H2sNWI1koxii', 'Usuário', '', 'Ativo'),
(16, 'Christiano da Silva Alencar', 'christiano.alencar@dpworld.com', '$2y$10$yVHMQFldMPSh6x.NzRfoReEhKTVLiIGCj/OUaZvZ.MdY9iSPIIkpG', 'Usuário', '7a48b5713c05225d7403007df1aca765', 'Ativo'),
(17, 'Hester Cruz Chaves', 'hester.chaves@dpworld.com', '$2y$10$NXZM97zHIGy9ZX0HcbRhn.QQ8S.Dp.YG7s5lN787/xgEkWM7NOl1K', 'Usuário', 'df3269f599d0bd88030034b1da6c2c3a', 'Ativo'),
(18, 'Marco Antonio Veloso Roseira', 'marco.veloso@dpworld.com', '$2y$10$6UX1a5GI9ZbvjG7R5FC7.e1hanyRMcdMLNNjWqWX1Pny9.OyxfWFK', 'Administrador', '', 'Ativo'),
(25, 'Thiago Barbosa', 'thiago-fa@hotmail.com', '$2y$10$DhnBnXYIoS5KNlUfHooNfuO.eQhZHV8rjE4iqC8UhllrpkFpjDVeK', 'Administrador', '219461ec4cbf5d328b9dc6f6598e977b', 'Ativo'),
(26, 'Thiago Barbosa dos Santos ', 'thiago.barbosa@dpworld.com', '$2y$10$y8qVrcG9I/Fw4jD6flhgguUcy2iAjBLp9CGGSal9N/wfZErPnaURK', 'Administrador', '9b95d5275446baec866113e1738629a6', 'Ativo');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ativos`
--
ALTER TABLE `ativos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `envolvidos`
--
ALTER TABLE `envolvidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ocorrenciaenvolvidos`
--
ALTER TABLE `ocorrenciaenvolvidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ocorrencias`
--
ALTER TABLE `ocorrencias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ativos`
--
ALTER TABLE `ativos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `envolvidos`
--
ALTER TABLE `envolvidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT de tabela `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de tabela `ocorrenciaenvolvidos`
--
ALTER TABLE `ocorrenciaenvolvidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `ocorrencias`
--
ALTER TABLE `ocorrencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
