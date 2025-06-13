<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum ConstantsTypes: string implements HasLabel
{
    case Continent = 'continent';
    case Religiosity = 'religiosity';
    case SocialTypes = 'social_types';
    case SocialStatuses = 'social_statuses';
    case Commitment = 'commitment';
    case SaudiDirection = 'saudi_direction';
    case SaudiIssueDirection = 'saudi_issue_direction';
    case Sectors = 'sectors';
    case Dimensions = 'dimensions';
    case InfluenceLevels = 'influence_levels';
    case InfluenceTypes = 'influence_types';
    case DocumentationTypes = 'documentation_types';
    case OrganizationsTypes = 'organizations_types';
    case OrganizationsLevels = 'organizations_levels';
    case InstitutionTypes = 'institution_types';
    case AdditionReasons = 'addition_reasons';
    case OrganizationsStatuses = 'organizations_statuses';
    case OrganizationsInRoles = 'organizations_in_roles';
    case OrganizationsRoles = 'organizations_roles';
    case ContributorRoles = 'contributor_roles';
    case PoliticalOrientation = 'political_orientation';
    case Specializations = 'specializations';
    case FameReasons = 'fame_reasons';
    case Positions = 'positions';
    case PositionsTypes = 'positions_types';
    case ArticlesTypes = 'articles_types';
    case SourceLocations = 'source_locations';
    case IssuesTypes = 'issues_types';
    case Achievements = 'achievements';
    case PoliticalPositions = 'political_positions';
    case MoneyResources = 'money_resources';
    //    case PublishInstitutionType = 'publish_institution_type';
    case Languages = 'languages';
    case AddedReasons = 'added_reasons';
    case ReportDirections = 'report_directions';
    case Repetitions = 'repetitions';
    case ContributionType = 'contribution_type';
    case ContributionRoles = 'contribution_roles';

    public function getLabel(): ?string
    {
        return __('enum'.'.'.$this->value);
    }
}
