# Data

## Structures

### Submission

- id
- firstname
- lastname
- contact
- email
- validated
- submitted
- created_at
- updated_at
- deleted_at
  
### Submission Entry

- id
- business_id (nullable)
- submission_id
- store_name
- address
- parish
- county
- district
- postal_code
- lat (double with 5 decimal places)
- long (double with 5 decimal places)
- phone_number
- sector
- created_at
- updated_at

### Submission Schedule

- id
- submission_entry_id
- start_hour
- end_hour
- sunday
- monday
- tuesday
- wednesday
- thrusday
- friday
- saturday
- type
- created_at
- updated_at

### Business

- id
- store_name
- address
- parish
- county
- district
- postal_code
- lat (double with 5 decimal places)
- long (double with 5 decimal places)
- phone_number
- sector

### Business Schedule

- id
- business_id
- start_hour
- end_hour
- sunday
- monday
- tuesday
- wednesday
- thrusday
- friday
- saturday
- type

---

## Enumerators

### Types

- 1 - Forças de Segurança, Entidades de Proteção Civil e Profissionais de Saúde
- 2 - Idosos / Maiores de 65 anos / Grupo de Risco
- 3 - Público Geral

### Sectors

- 1 - Minimercados, supermercados, hipermercados
- 2 - Frutarias, talhos, peixarias, padarias
- 3 - Mercados, para venda de produtos alimentares
- 4 - Produção e distribuição agroalimentar
- 5 - Lotas
- 6 - Restauração e bebidas, apenas para take-away
- 7 - Confeção de refeições prontas a levar para casa, apenas take-away
- 8 - Serviços médicos ou outros serviços de saúde e apoio social
- 9 - Farmácias e Parafarmácias
- 10 - Lojas de produtos médicos e ortopédicos
- 11 - Oculistas
- 12 - Lojas de produtos cosméticos e de higiene
- 13 - Lojas de produtos naturais e dietéticos
- 14 - Serviços públicos essenciais de água, energia elétrica, gás natural e gases de petróleo liquefeitos canalizados
- 15 - Serviços recolha e tratamento de águas residuais, recolha e tratamento de águas residuais e resíduos sólidos urbanos, higiene urbana e serviço de transporte de passageiros
- 16 - Serviços de comunicações eletrónicas e correios
- 17 - Papelarias, tabacarias e jogos sociais
- 18 - Clínicas veterinárias
- 19 - Lojas de venda de animais de companhia e respetivos alimentos
- 20 - Lojas de venda de flores, plantas, sementes e fertilizantes
- 21 - Lojas de lavagem e limpeza a seco de roupa
- 22 - Drogarias
- 23 - Lojas de bricolage e outros
- 24 - Postos de abastecimento de combustível
- 25 - Estabelecimentos de venda de combustíveis para uso doméstico;
- 26 - Oficinas e venda de peças mecânicas
- 27 - Lojas de venda e reparação de eletrodomésticos, equipamento informático e de comunicações e respetiva reparação
- 28 - Bancos, Seguros e Serviços Financeiros
- 29 - Funerárias
- 30 - Serviços de manutenção e reparações, em casa
- 31 - Serviços de segurança ou de vigilância, em casa
- 32 - Atividades de limpeza, desinfeção, desratização e similares
- 33 - Serviços de entrega ao domicílio
- 34 - Estabelecimentos turísticos, exceto parques de campismo, apenas com serviço de restaurante e bar para os respectivos hóspedes
- 35 - Serviços que garantam alojamento estudantil
- 36 - Atividades e estabelecimentos enunciados nos números anteriores, ainda que integrados em centros comerciais
