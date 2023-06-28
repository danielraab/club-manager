<?php

namespace App\Models\Import;

use App\Models\Member;

class MemberChangesWrapper
{
    public Member $original;
    public ImportedMember $imported;
    /**
     * @var string[]
     */
    public array $attributeDifferenceList;

    /**
     * @param Member $original
     * @param ImportedMember $imported
     * @param string[] $differentPropertyList
     */
    public function __construct(Member $original, ImportedMember $imported, array $differentPropertyList)
    {
        $this->original = $original;
        $this->imported = $imported;
        $this->attributeDifferenceList = $differentPropertyList;
    }


}
