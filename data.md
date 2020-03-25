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

### Submission Entry Schedule

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
- firstname
- lastname
- contact
- email
- created_at
- updated_at

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
- created_at
- updated_at
- deleted_at

---

## Enumerators

### Types

- 0 - Forças de Segurança, Entidades de Proteção Civil e Profissionais de Saúde
- 1 - Idosos / Maiores de 65 anos / Grupo de Risco
- 2 - Público Geral

### Sectors

- 0 - Minimercados, supermercados, hipermercados
- 1 - Frutarias, talhos, peixarias, padarias
- 2 - Mercados, para venda de produtos alimentares
- 3 - Produção e distribuição agroalimentar
- 4 - Lotas
- 5 - Restauração e bebidas, apenas para take-away
- 6 - Confeção de refeições prontas a levar para casa, apenas take-away
- 7 - Serviços médicos ou outros serviços de saúde e apoio social
- 8 - Farmácias e Parafarmácias
- 9 - Lojas de produtos médicos e ortopédicos
- 10 - Oculistas
- 11 - Lojas de produtos cosméticos e de higiene
- 12 - Lojas de produtos naturais e dietéticos
- 13 - Serviços públicos essenciais de água, energia elétrica, gás natural e gases de petróleo liquefeitos canalizados
- 14 - Serviços recolha e tratamento de águas residuais, recolha e tratamento de águas residuais e resíduos sólidos urbanos, higiene urbana e serviço de transporte de passageiros
- 15 - Serviços de comunicações eletrónicas e correios
- 16 - Papelarias, tabacarias e jogos sociais
- 17 - Clínicas veterinárias
- 18 - Lojas de venda de animais de companhia e respetivos alimentos
- 19 - Lojas de venda de flores, plantas, sementes e fertilizantes
- 20 - Lojas de lavagem e limpeza a seco de roupa
- 21 - Drogarias
- 22 - Lojas de bricolage e outros
- 23 - Postos de abastecimento de combustível
- 24 - Estabelecimentos de venda de combustíveis para uso doméstico;
- 25 - Oficinas e venda de peças mecânicas
- 26 - Lojas de venda e reparação de eletrodomésticos, equipamento informático e de comunicações e respetiva reparação
- 27 - Bancos, Seguros e Serviços Financeiros
- 28 - Funerárias
- 29 - Serviços de manutenção e reparações, em casa
- 30 - Serviços de segurança ou de vigilância, em casa
- 31 - Atividades de limpeza, desinfeção, desratização e similares
- 32 - Serviços de entrega ao domicílio
- 33 - Estabelecimentos turísticos, exceto parques de campismo, apenas com serviço de restaurante e bar para os respectivos hóspedes
- 34 - Serviços que garantam alojamento estudantil
- 35 - Atividades e estabelecimentos enunciados nos números anteriores, ainda que integrados em centros comerciais
